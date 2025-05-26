<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Initialize variables
$sales = [];
$error = null;
$total_revenue = 0;

// Get date filter parameters
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01'); // First day of current month
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d'); // Today

try {
    // Get all sales with product details
    $stmt = $pdo->prepare("
        SELECT 
            s.*,
            i.name as product_name,
            i.price as unit_price,
            o.payment_method,
            DATE(s.sale_date) as sale_date_only
        FROM sales s
        LEFT JOIN inventory i ON s.product_id = i.id
        LEFT JOIN orders o ON s.order_id = o.id
        WHERE DATE(s.sale_date) BETWEEN ? AND ?
        ORDER BY s.sale_date DESC
    ");
    
    $stmt->execute([$start_date, $end_date]);
    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate total revenue
    $stmt = $pdo->prepare("
        SELECT SUM(amount) as total
        FROM sales
        WHERE DATE(sale_date) BETWEEN ? AND ?
    ");
    $stmt->execute([$start_date, $end_date]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_revenue = $result['total'] ?? 0;

} catch(PDOException $e) {
    $error = "Error fetching sales: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Records - Hot Wheels Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .sales-card {
            transition: transform 0.2s;
        }
        .sales-card:hover {
            transform: translateY(-5px);
        }
        .total-revenue {
            font-size: 2rem;
            font-weight: bold;
            color: #198754;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            .print-only {
                display: block !important;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark no-print">
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
                        <a class="nav-link" href="manage_products.php">Manage Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_orders.php">Manage Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="sales.php">Sales Records</a>
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
            <h2>Sales Records</h2>
            <div class="d-flex gap-2 no-print">
                <button class="btn btn-outline-primary" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print Report
                </button>
            </div>
        </div>

        <!-- Date Filter Form -->
        <form class="row g-3 mb-4 no-print">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" 
                       value="<?php echo htmlspecialchars($start_date); ?>">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" 
                       value="<?php echo htmlspecialchars($end_date); ?>">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <!-- Print Header -->
        <div class="print-only" style="display: none;">
            <h3 class="text-center">Hot Wheels Collection - Sales Report</h3>
            <p class="text-center">
                Period: <?php echo date('F d, Y', strtotime($start_date)); ?> - 
                       <?php echo date('F d, Y', strtotime($end_date)); ?>
            </p>
        </div>

        <!-- Total Revenue Card -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Total Revenue</h5>
                <p class="total-revenue">₱<?php echo number_format($total_revenue, 2); ?></p>
                <p class="text-muted mb-0">
                    For period: <?php echo date('F d, Y', strtotime($start_date)); ?> - 
                    <?php echo date('F d, Y', strtotime($end_date)); ?>
                </p>
            </div>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Quantity</th>
                        <th>Payment Method</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($sales)): ?>
                        <?php foreach ($sales as $sale): ?>
                            <tr>
                                <td><?php echo date('M d, Y h:i A', strtotime($sale['sale_date'])); ?></td>
                                <td>#<?php echo htmlspecialchars($sale['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($sale['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($sale['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars($sale['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($sale['payment_method']); ?></td>
                                <td class="text-end">₱<?php echo number_format($sale['amount'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-inbox display-1 text-muted"></i>
                                <p class="lead mt-3">No sales records found for the selected period</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="table-dark">
                        <td colspan="6" class="text-end"><strong>Total:</strong></td>
                        <td class="text-end"><strong>₱<?php echo number_format($total_revenue, 2); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-submit form when dates change
        document.getElementById('start_date').addEventListener('change', function() {
            this.form.submit();
        });
        document.getElementById('end_date').addEventListener('change', function() {
            this.form.submit();
        });
    </script>
</body>
</html> 