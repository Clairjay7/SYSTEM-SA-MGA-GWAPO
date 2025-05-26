<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Initialize variables
$todays_sales = 0;
$recent_sales = [];
$total_orders = 0;
$pending_orders = 0;
$low_stock_items = [];

try {
    // Get today's sales
    $today = date('Y-m-d');
    $stmt = $pdo->prepare("
        SELECT SUM(amount) as total 
        FROM sales 
        WHERE DATE(sale_date) = ?
    ");
    $stmt->execute([$today]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $todays_sales = $result['total'] ?? 0;

    // Get recent sales (last 5)
    $stmt = $pdo->query("
        SELECT 
            s.*,
            i.name as product_name,
            o.payment_method
        FROM sales s
        LEFT JOIN inventory i ON s.product_id = i.id
        LEFT JOIN orders o ON s.order_id = o.id
        ORDER BY s.sale_date DESC
        LIMIT 5
    ");
    $recent_sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get order counts
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM orders");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_orders = $result['total'];

    $stmt = $pdo->query("SELECT COUNT(*) as pending FROM orders WHERE status = 'pending'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $pending_orders = $result['pending'];

    // Get low stock items (less than 5 items)
    $stmt = $pdo->query("
        SELECT id, name, quantity 
        FROM inventory 
        WHERE quantity < 5 
        ORDER BY quantity ASC
    ");
    $low_stock_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $error = "Error fetching dashboard data: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Hot Wheels Collection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .dashboard-card {
            transition: transform 0.2s;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .stat-card {
            border-left: 4px solid;
        }
        .revenue-card {
            border-left-color: #198754;
        }
        .orders-card {
            border-left-color: #0d6efd;
        }
        .pending-card {
            border-left-color: #ffc107;
        }
        .stock-card {
            border-left-color: #dc3545;
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
                        <a class="nav-link" href="manage_products.php">Manage Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_orders.php">Manage Orders</a>
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
        <h2 class="mb-4">Dashboard Overview</h2>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card dashboard-card stat-card revenue-card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Today's Sales</h6>
                        <h3 class="card-title mb-0">₱<?php echo number_format($todays_sales, 2); ?></h3>
                        <a href="sales.php" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card stat-card orders-card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Total Orders</h6>
                        <h3 class="card-title mb-0"><?php echo number_format($total_orders); ?></h3>
                        <a href="manage_orders.php" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card stat-card pending-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Products</h6>
                                <h3 class="card-title mb-0">Manage</h3>
                            </div>
                            <div class="fs-1 text-primary">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                        <a href="manage_products.php" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card stat-card stock-card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Low Stock Items</h6>
                        <h3 class="card-title mb-0"><?php echo count($low_stock_items); ?></h3>
                        <a href="manage_products.php" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Sales -->
            <div class="col-md-8">
                <div class="card dashboard-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Sales</h5>
                        <a href="sales.php" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Product</th>
                                        <th>Customer</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recent_sales)): ?>
                                        <?php foreach ($recent_sales as $sale): ?>
                                            <tr>
                                                <td><?php echo date('M d, Y', strtotime($sale['sale_date'])); ?></td>
                                                <td><?php echo htmlspecialchars($sale['product_name']); ?></td>
                                                <td><?php echo htmlspecialchars($sale['customer_name']); ?></td>
                                                <td class="text-end">₱<?php echo number_format($sale['amount'], 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No recent sales</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Low Stock Alert -->
            <div class="col-md-4">
                <div class="card dashboard-card">
                    <div class="card-header">
                        <h5 class="mb-0">Low Stock Alert</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($low_stock_items)): ?>
                            <div class="list-group">
                                <?php foreach ($low_stock_items as $item): ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0"><?php echo htmlspecialchars($item['name']); ?></h6>
                                            <small class="text-muted">Stock: <?php echo $item['quantity']; ?></small>
                                        </div>
                                        <?php if ($item['quantity'] == 0): ?>
                                            <span class="badge bg-danger">Out of Stock</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Low Stock</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-center mb-0">No low stock items</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>