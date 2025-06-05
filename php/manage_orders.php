<!-- filepath: f:\xammp\htdocs\SYSTEM-SA-MGA-GWAPO\php\manage_orders.php -->
<?php
session_start();
require_once '../config/database.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Initialize variables
$orders = [];
$error = null;
$debug_message = '';

// Check and alter transaction_logs table if needed
try {
    $stmt = $pdo->query("SHOW COLUMNS FROM transaction_logs LIKE 'updated_at'");
    if ($stmt->rowCount() === 0) {
        // Add updated_at column if it doesn't exist
        $pdo->exec("ALTER TABLE transaction_logs ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
    }
} catch(PDOException $e) {
    error_log("Error checking/updating transaction_logs table: " . $e->getMessage());
}

// Handle order status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();

        // Handle refund and cancellation
        if (isset($_POST['refund_order_id']) && isset($_POST['refund_reason'])) {
            $order_id = $_POST['refund_order_id'];
            $refund_reason = $_POST['refund_reason'];
            $new_status = 'cancelled';

            // Get order details
            $stmt = $pdo->prepare("
                SELECT 
                    o.*,
                    i.name as product_name,
                    i.price as unit_price,
                    i.quantity as current_stock,
                    s.id as sale_id
                FROM orders o 
                LEFT JOIN inventory i ON o.product_id = i.id 
                LEFT JOIN sales s ON o.id = s.order_id
                WHERE o.id = ?
            ");
            $stmt->execute([$order_id]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$order) {
                throw new Exception("Order not found");
            }

            $current_status = strtolower($order['status']);

            if ($current_status === 'completed') {
                // Create refund record
                $refund_amount = $order['quantity'] * $order['price'];
                $stmt = $pdo->prepare("
                    INSERT INTO refunds (
                        order_id, 
                        amount, 
                        reason, 
                        status,
                        created_at
                    ) VALUES (?, ?, ?, 'completed', CURRENT_TIMESTAMP)
                ");
                $stmt->execute([$order_id, $refund_amount, $refund_reason]);

                // Update transaction logs to show refunded status
                $stmt = $pdo->prepare("
                    UPDATE transaction_logs 
                    SET status = 'refunded',
                        type = 'refund',
                        amount = ?
                    WHERE order_id = ?
                ");
                $stmt->execute([$refund_amount, $order_id]);

                // Also insert a new refund transaction log
                $stmt = $pdo->prepare("
                    INSERT INTO transaction_logs (
                        order_id,
                        type,
                        status,
                        amount,
                        created_at
                    ) VALUES (?, 'refund', 'completed', ?, CURRENT_TIMESTAMP)
                ");
                $stmt->execute([$order_id, $refund_amount]);

                // Delete the sales record
                $stmt = $pdo->prepare("DELETE FROM sales WHERE order_id = ?");
                $stmt->execute([$order_id]);

                // Return stock to inventory
                $stmt = $pdo->prepare("
                    UPDATE inventory 
                    SET quantity = quantity + ?,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = ?
                ");
                $stmt->execute([$order['quantity'], $order['product_id']]);

                // Log the inventory movement
                $stmt = $pdo->prepare("
                    INSERT INTO inventory_movements (
                        product_id, quantity, type, reference_id, reference_type, created_at
                    ) VALUES (?, ?, 'in', ?, 'refund', CURRENT_TIMESTAMP)
                ");
                $stmt->execute([
                    $order['product_id'],
                    $order['quantity'],
                    $order_id
                ]);

                // Update order status
                $stmt = $pdo->prepare("
                    UPDATE orders 
                    SET status = ?,
                        updated_at = CURRENT_TIMESTAMP 
                    WHERE id = ?
                ");
                $stmt->execute(['cancelled', $order_id]);

                $pdo->commit();
                $_SESSION['success'] = "Order #$order_id has been refunded (₱" . number_format($refund_amount, 2) . "). Stock has been returned and sales record has been removed.";
                header("Location: manage_orders.php");
                exit();
            }
        }
        // Handle regular status updates
        else if (isset($_POST['order_id']) && isset($_POST['new_status'])) {
            $order_id = $_POST['order_id'];
            $new_status = strtolower($_POST['new_status']); // Convert to lowercase
            
            // Get complete order details before updating
            $stmt = $pdo->prepare("
                SELECT 
                    o.*,
                    i.name as product_name,
                    i.price as unit_price,
                    i.quantity as current_stock,
                    s.id as sale_id
                FROM orders o 
                LEFT JOIN inventory i ON o.product_id = i.id 
                LEFT JOIN sales s ON o.id = s.order_id
                WHERE o.id = ?
            ");
            $stmt->execute([$order_id]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$order) {
                throw new Exception("Order not found");
            }

            // Convert current status to lowercase for comparison
            $current_status = strtolower($order['status']);

            // Handle cancellation of completed order
            if ($new_status === 'cancelled' && $current_status === 'completed') {
                // First, delete the sales record
                $stmt = $pdo->prepare("DELETE FROM sales WHERE order_id = ?");
                $stmt->execute([$order_id]);

                // Then return the stock to inventory
                $stmt = $pdo->prepare("
                    UPDATE inventory 
                    SET quantity = quantity + ?,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = ?
                ");
                $stmt->execute([$order['quantity'], $order['product_id']]);

                // Log the inventory movement
                $stmt = $pdo->prepare("
                    INSERT INTO inventory_movements (
                        product_id, quantity, type, reference_id, reference_type, created_at
                    ) VALUES (?, ?, 'in', ?, 'cancelled_order', CURRENT_TIMESTAMP)
                ");
                $stmt->execute([
                    $order['product_id'],
                    $order['quantity'],
                    $order_id
                ]);
            }
            // Handle completion of order
            else if ($new_status === 'completed' && $current_status !== 'completed') {
                if ($order['current_stock'] < $order['quantity']) {
                    throw new Exception("Not enough stock to complete this order");
                }

                // Reduce inventory
                $stmt = $pdo->prepare("
                    UPDATE inventory 
                    SET quantity = quantity - ?,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = ? AND quantity >= ?
                ");
                $stmt->execute([
                    $order['quantity'],
                    $order['product_id'],
                    $order['quantity']
                ]);

                // Calculate total amount properly
                $total_amount = $order['quantity'] * $order['price'];

                // Create sales record
                $stmt = $pdo->prepare("
                    INSERT INTO sales (
                        order_id,
                        product_id,
                        customer_name,
                        quantity,
                        amount,
                        sale_date
                    ) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)
                ");
                
                $stmt->execute([
                    $order_id,
                    $order['product_id'],
                    $order['customer_name'],
                    $order['quantity'],
                    $total_amount
                ]);

                // Log the inventory movement
                $stmt = $pdo->prepare("
                    INSERT INTO inventory_movements (
                        product_id, quantity, type, reference_id, reference_type, created_at
                    ) VALUES (?, ?, 'out', ?, 'completed_order', CURRENT_TIMESTAMP)
                ");
                $stmt->execute([
                    $order['product_id'],
                    -$order['quantity'],
                    $order_id
                ]);

                $_SESSION['success'] = "Order #$order_id has been completed. Total sale amount: ₱" . number_format($total_amount, 2);
                
                // Update transaction log status
                $stmt = $pdo->prepare("
                    UPDATE transaction_logs 
                    SET status = 'completed',
                        completed_at = CURRENT_TIMESTAMP
                    WHERE order_id = ? AND type = 'purchase'
                ");
                $stmt->execute([$order_id]);
            }

            // Update order status
            $stmt = $pdo->prepare("
                UPDATE orders 
                SET status = ?,
                    updated_at = CURRENT_TIMESTAMP 
                WHERE id = ?
            ");
            $stmt->execute([$new_status, $order_id]);

            $pdo->commit();

            if ($new_status === 'cancelled' && $current_status === 'completed') {
                $_SESSION['success'] = "Order #$order_id has been cancelled. Stock has been returned and sales record has been removed.";
            } else if ($new_status === 'completed') {
                $_SESSION['success'] = "Order #$order_id has been completed. Inventory has been updated and sale has been recorded.";
            } else {
                $_SESSION['success'] = "Order #$order_id status has been updated to $new_status.";
            }
            
            header("Location: manage_orders.php");
            exit();
        }

        // Add this after the existing POST handling code, before the "Get all orders" section
        if (isset($_POST['delete_order_id'])) {
            try {
                $pdo->beginTransaction();
                $order_id = $_POST['delete_order_id'];

                // Get order details first
                $stmt = $pdo->prepare("
                    SELECT * FROM orders 
                    WHERE id = ?
                ");
                $stmt->execute([$order_id]);
                $order = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($order) {
                    // Delete related records first
                    // Delete from sales if exists
                    $stmt = $pdo->prepare("DELETE FROM sales WHERE order_id = ?");
                    $stmt->execute([$order_id]);

                    // Delete from refunds if exists
                    $stmt = $pdo->prepare("DELETE FROM refunds WHERE order_id = ?");
                    $stmt->execute([$order_id]);

                    // Delete from transaction_logs if exists
                    $stmt = $pdo->prepare("DELETE FROM transaction_logs WHERE order_id = ?");
                    $stmt->execute([$order_id]);

                    // Finally delete the order
                    $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
                    $stmt->execute([$order_id]);

                    $pdo->commit();
                    $_SESSION['success'] = "Order #$order_id has been successfully deleted.";
                } else {
                    throw new Exception("Order not found");
                }
                
                header("Location: manage_orders.php");
                exit();
            } catch(Exception $e) {
                $pdo->rollBack();
                $error = "Error deleting order: " . $e->getMessage();
            }
        }
    } catch(Exception $e) {
        $pdo->rollBack();
        $error = "Error processing request: " . $e->getMessage();
    }
}

// Get all orders with details
try {
    $stmt = $pdo->prepare("
        SELECT 
            o.*,
            i.name as product_name,
            i.barcode as product_barcode,
            i.price,
            CASE 
                WHEN s.id IS NOT NULL THEN 1 
                ELSE 0 
            END as is_in_sales,
            s.id as sale_id,
            r.reason as refund_reason
        FROM orders o 
        LEFT JOIN inventory i ON o.product_id = i.id 
        LEFT JOIN sales s ON o.id = s.order_id
        LEFT JOIN refunds r ON o.id = r.order_id
        ORDER BY o.created_at DESC
    ");
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error = "Error fetching orders: " . $e->getMessage();
}

// Check if sales table exists
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'sales'");
    if ($stmt->rowCount() === 0) {
        // Create sales table if it doesn't exist
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS sales (
                id INT PRIMARY KEY AUTO_INCREMENT,
                order_id INT,
                product_id INT,
                customer_name VARCHAR(100),
                quantity INT,
                amount DECIMAL(10,2),
                sale_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (order_id) REFERENCES orders(id),
                FOREIGN KEY (product_id) REFERENCES inventory(id)
            )
        ");
        $debug_message .= "\nSales table created";
    }
} catch(PDOException $e) {
    $error = "Error checking/creating sales table: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Hot Wheels Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .order-card {
            transition: transform 0.2s;
            margin-bottom: 1rem;
        }
        .order-card:hover {
            transform: translateY(-5px);
        }
        .status-badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
        .order-details {
            font-size: 0.9rem;
        }
        .action-buttons {
            gap: 0.5rem;
        }
        .refund-reason {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: help;
        }
        .status-badge {
            font-size: 0.85em;
            padding: 5px 10px;
            border-radius: 15px;
        }
        .status-pending { background-color: #ffeeba; color: #856404; }
        .status-completed { background-color: #d4edda; color: #155724; }
        .status-cancelled { background-color: #f8d7da; color: #721c24; }
        .status-refunded { background-color: #e2e3e5; color: #383d41; }
        .tooltip-inner {
            max-width: 300px;
            text-align: left;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="homepage.php">View Site</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_users.php">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_products.php">Manage Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="manage_orders.php">Manage Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sales.php">Sales Records</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manage Orders</h2>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print Report
                </button>
            </div>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                <div class="col-12">
                    <div class="card order-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <h5 class="card-title mb-1">Order #<?php echo htmlspecialchars($order['id']); ?></h5>
                                    <p class="text-muted mb-0">
                                        <?php echo date('M d, Y h:i A', strtotime($order['created_at'])); ?>
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-1"><strong>Customer:</strong></p>
                                    <p class="mb-0"><?php echo htmlspecialchars($order['customer_name'] ?? 'Guest User'); ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-1"><strong>Product:</strong></p>
                                    <p class="mb-0"><?php echo htmlspecialchars($order['product_name']); ?></p>
                                    <p class="mb-0">Barcode: <?php echo htmlspecialchars($order['product_barcode'] ?? 'No barcode'); ?></p>
                                    <p class="mb-0">Quantity: <?php echo htmlspecialchars($order['quantity']); ?></p>
                                    <p class="mb-0">Unit Price: ₱<?php echo number_format($order['price'], 2); ?></p>
                                    <p class="mb-0">Total Amount: ₱<?php echo number_format($order['quantity'] * $order['price'], 2); ?></p>
                                </div>
                                <div class="col-md-3">
                                    <?php if (strtolower($order['status']) === 'completed'): ?>
                                        <button type="button" class="btn btn-warning mb-2" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#refundModal<?php echo $order['id']; ?>">
                                            Process Refund
                                        </button>
                                    <?php else: ?>
                                        <form method="POST" class="d-flex justify-content-end align-items-center action-buttons mb-2">
                                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                            <select name="new_status" class="form-select me-2" style="width: auto;">
                                                <option value="pending" <?php echo strtolower($order['status']) === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="completed" <?php echo strtolower($order['status']) === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                                <option value="cancelled" <?php echo strtolower($order['status']) === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </form>
                                    <?php endif; ?>
                                    
                                    <!-- Add Delete Button -->
                                    <button type="button" class="btn btn-danger w-100" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal<?php echo $order['id']; ?>">
                                        <i class="bi bi-trash"></i> Delete Order
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="badge bg-<?php 
                                    echo match(strtolower($order['status'])) {
                                        'completed' => 'success',
                                        'pending' => 'warning',
                                        'cancelled' => 'danger',
                                        default => 'secondary'
                                    };
                                ?> status-badge">
                                    <?php echo ucfirst(htmlspecialchars($order['status'])); ?>
                                </span>
                                <span class="badge bg-info status-badge">
                                    <?php echo htmlspecialchars($order['payment_method']); ?>
                                </span>
                                <?php if (isset($order['is_in_sales']) && $order['is_in_sales']): ?>
                                    <span class="badge bg-success status-badge">
                                        <i class="bi bi-check-circle-fill"></i> Recorded in Sales
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Refund Modal for each order -->
                    <div class="modal fade" id="refundModal<?php echo $order['id']; ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Process Refund for Order #<?php echo $order['id']; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST">
                                    <div class="modal-body">
                                        <input type="hidden" name="refund_order_id" value="<?php echo $order['id']; ?>">
                                        <div class="mb-3">
                                            <label for="refundAmount" class="form-label">Refund Amount</label>
                                            <input type="text" class="form-control" id="refundAmount" 
                                                   value="₱<?php echo number_format($order['price'] * $order['quantity'], 2); ?>" 
                                                   readonly>
                                            <small class="text-muted">
                                                (<?php echo $order['quantity']; ?> items × ₱<?php echo number_format($order['price'], 2); ?> each)
                                            </small>
                                        </div>
                                        <div class="mb-3">
                                            <label for="refundReason" class="form-label">Reason for Refund</label>
                                            <textarea class="form-control" name="refund_reason" id="refundReason" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-warning">Process Refund</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal for each order -->
                    <div class="modal fade" id="deleteModal<?php echo $order['id']; ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete Order #<?php echo $order['id']; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this order? This action cannot be undone.</p>
                                    <div class="alert alert-warning">
                                        <strong>Order Details:</strong><br>
                                        Customer: <?php echo htmlspecialchars($order['customer_name']); ?><br>
                                        Product: <?php echo htmlspecialchars($order['product_name']); ?><br>
                                        Amount: ₱<?php echo number_format($order['quantity'] * $order['price'], 2); ?><br>
                                        Status: <?php echo ucfirst(htmlspecialchars($order['status'])); ?>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="delete_order_id" value="<?php echo $order['id']; ?>">
                                        <button type="submit" class="btn btn-danger">Delete Order</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <p class="lead mt-3">No orders found</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>
</body>
</html>