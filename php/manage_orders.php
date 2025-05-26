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

// Handle order status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['new_status'])) {
    try {
        $pdo->beginTransaction();

        $order_id = $_POST['order_id'];
        $new_status = $_POST['new_status'];
        
        // Get complete order details before updating
        $stmt = $pdo->prepare("
            SELECT 
                o.*,
                i.name as product_name,
                i.price as unit_price,
                i.quantity as current_stock
            FROM orders o 
            LEFT JOIN inventory i ON o.product_id = i.id 
            WHERE o.id = ?
        ");
        $stmt->execute([$order_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            throw new Exception("Order not found");
        }

        // If completing the order, check if there's enough stock
        if ($new_status === 'completed' && $order['status'] !== 'completed') {
            if ($order['current_stock'] < $order['quantity']) {
                throw new Exception("Not enough stock to complete this order");
            }

            // Update inventory - reduce stock
            $stmt = $pdo->prepare("
                UPDATE inventory 
                SET 
                    quantity = quantity - ?,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = ? AND quantity >= ?
            ");
            
            $result = $stmt->execute([
                $order['quantity'],
                $order['product_id'],
                $order['quantity']
            ]);

            if (!$result) {
                throw new Exception("Failed to update inventory");
            }

            // Record the sale
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

            $total_amount = $order['quantity'] * $order['unit_price'];
            
            $stmt->execute([
                $order_id,
                $order['product_id'],
                $order['customer_name'],
                $order['quantity'],
                $total_amount
            ]);
        }

        // Update order status
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$new_status, $order_id]);

        $pdo->commit();
        $_SESSION['success'] = "Order #$order_id has been " . strtolower($new_status) . " successfully!";
        
        if ($new_status === 'completed') {
            $_SESSION['success'] .= " Inventory has been updated and sale has been recorded.";
        }
        
        header("Location: manage_orders.php");
        exit();
    } catch(Exception $e) {
        $pdo->rollBack();
        $error = "Error updating order: " . $e->getMessage();
    }
}

// Get all orders with details
try {
    $stmt = $pdo->query("
        SELECT 
            o.*,
            i.name as product_name,
            i.price as unit_price,
            i.quantity as current_stock,
            (o.quantity * i.price) as total_amount,
            CASE 
                WHEN s.id IS NOT NULL THEN 1 
                ELSE 0 
            END as is_in_sales
        FROM orders o
        LEFT JOIN inventory i ON o.product_id = i.id
        LEFT JOIN sales s ON o.id = s.order_id
        ORDER BY o.created_at DESC
    ");
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
                                    <p class="mb-0"><?php echo htmlspecialchars($order['customer_name']); ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-1"><strong>Product:</strong></p>
                                    <p class="mb-0"><?php echo htmlspecialchars($order['product_name']); ?></p>
                                    <p class="mb-0">Quantity: <?php echo htmlspecialchars($order['quantity']); ?></p>
                                    <p class="mb-0">Price: ₱<?php echo number_format($order['price'], 2); ?></p>
                                </div>
                                <div class="col-md-3">
                                    <form method="POST" class="d-flex justify-content-end align-items-center action-buttons">
                                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                        <select name="new_status" class="form-select me-2" style="width: auto;">
                                            <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="completed" <?php echo $order['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                            <option value="cancelled" <?php echo $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
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
                                <?php if ($order['is_in_sales']): ?>
                                    <span class="badge bg-success status-badge">
                                        <i class="bi bi-check-circle-fill"></i> Recorded in Sales
                                    </span>
                                <?php endif; ?>
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
</body>
</html>