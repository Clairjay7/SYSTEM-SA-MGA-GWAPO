<?php
session_start();
require_once '../config/database.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debug session
error_log("Admin Dashboard - Session data: " . print_r($_SESSION, true));

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    error_log("Access denied to admin dashboard. Session: " . print_r($_SESSION, true));
    header("Location: ../index.php");
    exit();
}

// Initialize variables
$todays_sales = 0;
$recent_sales = [];
$total_orders = 0;
$pending_orders = 0;
$low_stock_items = [];
$recent_refunds = [];
$recent_transactions = [];
$system_status = [
    'database' => $pdo ? 'Connected' : 'Disconnected',
    'php_version' => PHP_VERSION,
    'server_software' => $_SERVER['SERVER_SOFTWARE'],
    'last_update' => date('Y-m-d H:i:s')
];

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
            o.payment_method,
            o.customer_name
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
        WHERE quantity < 5 AND deleted_at IS NULL
        ORDER BY quantity ASC
    ");
    $low_stock_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get recent refunds (last 5)
    $stmt = $pdo->query("
        SELECT 
            r.*,
            o.customer_name,
            i.name as product_name
        FROM refunds r
        JOIN orders o ON r.order_id = o.id
        JOIN inventory i ON o.product_id = i.id
        ORDER BY r.created_at DESC
        LIMIT 5
    ");
    $recent_refunds = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get recent transactions (last 10)
    $stmt = $pdo->query("
        SELECT 
            tl.*,
            o.customer_name,
            i.name as product_name
        FROM transaction_logs tl
        LEFT JOIN orders o ON tl.order_id = o.id
        LEFT JOIN inventory i ON o.product_id = i.id
        ORDER BY tl.created_at DESC
        LIMIT 10
    ");
    $recent_transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $error = "Error fetching dashboard data: " . $e->getMessage();
}

// Get system metrics
function getSystemMetrics($pdo) {
    $metrics = [];
    
    try {
        // Get total orders and order status counts
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM orders");
        $metrics['total_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $stmt = $pdo->query("
            SELECT status, COUNT(*) as count 
            FROM orders 
            GROUP BY status
        ");
        $metrics['orders_by_status'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get total and today's sales
        $stmt = $pdo->query("SELECT SUM(amount) as total FROM sales");
        $metrics['total_sales'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        
        $today = date('Y-m-d');
        $stmt = $pdo->prepare("
            SELECT COUNT(*) as count, SUM(amount) as total 
            FROM sales 
            WHERE DATE(sale_date) = ?
        ");
        $stmt->execute([$today]);
        $metrics['today_stats'] = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Get inventory metrics
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM inventory WHERE deleted_at IS NULL");
        $metrics['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $stmt = $pdo->query("
            SELECT id, name, quantity 
            FROM inventory 
            WHERE quantity < 5 AND deleted_at IS NULL 
            ORDER BY quantity ASC
        ");
        $metrics['low_stock_items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get recent transactions with more details
        $stmt = $pdo->query("
            SELECT 
                t.*,
                o.customer_name,
                o.payment_method,
                i.name as product_name,
                i.quantity as current_stock
            FROM transaction_logs t
            LEFT JOIN orders o ON t.order_id = o.id
            LEFT JOIN inventory i ON o.product_id = i.id
            ORDER BY t.created_at DESC
            LIMIT 10
        ");
        $metrics['recent_transactions'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get system performance metrics
        $metrics['system_status'] = [
            'database' => $pdo ? 'Connected' : 'Disconnected',
            'php_version' => PHP_VERSION,
            'server_software' => $_SERVER['SERVER_SOFTWARE'],
            'memory_usage' => memory_get_usage(true),
            'disk_free_space' => disk_free_space("/"),
            'last_update' => date('Y-m-d H:i:s')
        ];
        
    } catch(PDOException $e) {
        error_log("Error fetching metrics: " . $e->getMessage());
        $metrics['error'] = "Error fetching dashboard metrics";
    }
    
    return $metrics;
}

// Get system status
$systemStatus = [
    'database' => $pdo ? 'Connected' : 'Disconnected',
    'php_version' => PHP_VERSION,
    'server_software' => $_SERVER['SERVER_SOFTWARE'],
    'memory_usage' => memory_get_usage(true),
    'disk_free_space' => disk_free_space("/"),
    'last_update' => date('Y-m-d H:i:s')
];

// Handle barcode search
$barcode_result = null;
$barcode_error = '';
if (isset($_GET['barcode']) && !empty($_GET['barcode'])) {
    try {
        $stmt = $pdo->prepare("
            SELECT * FROM inventory 
            WHERE barcode = ? AND deleted_at IS NULL
        ");
        $stmt->execute([trim($_GET['barcode'])]);
        $barcode_result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$barcode_result) {
            $barcode_error = "No product found with barcode: " . htmlspecialchars($_GET['barcode']);
        }
    } catch(PDOException $e) {
        $barcode_error = "Error searching barcode: " . $e->getMessage();
    }
}

// Get metrics
$metrics = getSystemMetrics($pdo);

// Add API Status check function after getSystemMetrics
function checkApiEndpoints() {
    $endpoints = [
        'routes' => '../API/routes.php',
        'guest_sessions' => '../API/guest_sessions.php',
        'TransactionController' => '../API/TransactionController.php',
        'users' => '../API/users.php',
        'orders' => '../API/orders.php',
        'products' => '../API/products.php'
    ];
    
    $results = [];
    foreach ($endpoints as $name => $path) {
        $status = file_exists($path) ? 'ok' : 'error';
        $results[$name] = [
            'path' => $path,
            'status' => $status
        ];
    }
    return $results;
}

// Get API status
$api_status = checkApiEndpoints();
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
        :root {
            --primary-bg: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --hover-transform: translateY(-5px);
        }

        body {
            background-color: var(--primary-bg);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .dashboard-card {
            background: white;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            margin-bottom: 1.5rem;
        }

        .dashboard-card:hover {
            transform: var(--hover-transform);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .metric-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-left: 4px solid;
        }
        
        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        .metric-card.sales { border-left-color: #198754; }
        .metric-card.orders { border-left-color: #0d6efd; }
        .metric-card.products { border-left-color: #6f42c1; }
        .metric-card.alerts { border-left-color: #dc3545; }
        
        .metric-value {
            font-size: 2rem;
            font-weight: bold;
            color: #0d6efd;
            margin: 0.5rem 0;
        }
        
        .metric-label {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .status-completed { 
            background-color: #d1e7dd !important; 
            color: #0f5132 !important; 
        }
        
        .status-pending { 
            background-color: #fff3cd !important; 
            color: #856404 !important; 
        }
        
        .status-cancelled { 
            background-color: #f8d7da !important; 
            color: #842029 !important; 
        }
        
        .status-refunded { 
            background-color: #e2e3ff !important; 
            color: #2d31a6 !important; 
        }
        
        .status-failed { 
            background-color: #842029 !important; 
            color: #ffffff !important; 
        }
        
        .system-status {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .status-item {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
        }
        
        .refresh-button {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #0d6efd;
            color: white;
            border: none;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .refresh-button:hover {
            transform: rotate(180deg);
            background: #0b5ed7;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .alert-pulse {
            animation: pulse 2s infinite;
        }

        .barcode-search {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: var(--card-shadow);
        }

        .barcode-result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
        }

        .barcode-result.found {
            background: #d4edda;
            border: 1px solid #c3e6cb;
        }

        .barcode-result.not-found {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
        }

        .product-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .product-detail-item {
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .metric-value {
                font-size: 1.5rem;
            }
        }

        .api-status-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }
        
        .api-endpoint {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .api-endpoint:last-child {
            border-bottom: none;
        }
        
        .api-path {
            color: #6c757d;
            font-family: monospace;
            font-size: 0.9rem;
        }
        
        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .status-ok {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        
        .status-error {
            background-color: #f8d7da;
            color: #842029;
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
        <!-- Barcode Search Section -->
        <div class="barcode-search dashboard-card">
            <h3 class="mb-4"><i class="bi bi-upc-scan"></i> Barcode Search</h3>
            <form method="GET" class="row g-3">
                <div class="col-md-8">
                    <input type="text" class="form-control form-control-lg" 
                           name="barcode" placeholder="Enter barcode" 
                           value="<?php echo isset($_GET['barcode']) ? htmlspecialchars($_GET['barcode']) : ''; ?>"
                           autofocus>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>

            <?php if (isset($_GET['barcode']) && !empty($_GET['barcode'])): ?>
                <?php if ($barcode_result): ?>
                    <div class="barcode-result found">
                        <h4 class="text-success mb-3">
                            <i class="bi bi-check-circle-fill"></i> Product Found
                        </h4>
                        <div class="product-details">
                            <div class="product-detail-item">
                                <div class="product-detail-label">Barcode</div>
                                <div class="barcode-display">
                                    <i class="bi bi-upc"></i> <?php echo htmlspecialchars($barcode_result['barcode']); ?>
                                </div>
                            </div>
                            <div class="product-detail-item">
                                <div class="product-detail-label">Name</div>
                                <?php echo htmlspecialchars($barcode_result['name']); ?>
                            </div>
                            <div class="product-detail-item">
                                <div class="product-detail-label">Price</div>
                                ₱<?php echo number_format($barcode_result['price'], 2); ?>
                            </div>
                            <div class="product-detail-item">
                                <div class="product-detail-label">Quantity in Stock</div>
                                <?php echo number_format($barcode_result['quantity']); ?>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="edit_product.php?id=<?php echo $barcode_result['id']; ?>" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit Product
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="barcode-result not-found">
                        <h4 class="text-danger mb-0">
                            <i class="bi bi-x-circle-fill"></i> <?php echo $barcode_error; ?>
                        </h4>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- System Metrics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="metric-card sales">
                    <i class="bi bi-currency-dollar fs-1 text-success"></i>
                    <div class="metric-value">₱<?php echo number_format($metrics['today_stats']['total'] ?? 0, 2); ?></div>
                    <div class="metric-label">Today's Sales</div>
                    <small class="text-muted"><?php echo $metrics['today_stats']['count'] ?? 0; ?> orders</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card orders">
                    <i class="bi bi-cart-check fs-1 text-primary"></i>
                    <div class="metric-value"><?php echo number_format($metrics['total_orders']); ?></div>
                    <div class="metric-label">Total Orders</div>
                    <small class="text-muted">
                        <?php 
                        $pending = array_filter($metrics['orders_by_status'], function($status) {
                            return $status['status'] === 'pending';
                        });
                        echo count($pending) . ' pending';
                        ?>
                    </small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card products">
                    <i class="bi bi-box-seam fs-1 text-purple"></i>
                    <div class="metric-value"><?php echo number_format($metrics['total_products']); ?></div>
                    <div class="metric-label">Total Products</div>
                    <small class="text-muted"><?php echo count($metrics['low_stock_items']); ?> low stock</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card alerts <?php echo count($metrics['low_stock_items']) > 0 ? 'alert-pulse' : ''; ?>">
                    <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>
                    <div class="metric-value"><?php echo count($metrics['low_stock_items']); ?></div>
                    <div class="metric-label">Low Stock Alerts</div>
                    <small class="text-muted">Needs attention</small>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card dashboard-card">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0">System Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="system-status">
                            <div class="status-item">
                                <h6>Database</h6>
                                <span class="badge bg-<?php echo $metrics['system_status']['database'] === 'Connected' ? 'success' : 'danger'; ?>">
                                    <?php echo $metrics['system_status']['database']; ?>
                                </span>
                            </div>
                            <div class="status-item">
                                <h6>PHP Version</h6>
                                <span class="badge bg-info"><?php echo $metrics['system_status']['php_version']; ?></span>
                            </div>
                            <div class="status-item">
                                <h6>Memory Usage</h6>
                                <span class="badge bg-secondary">
                                    <?php echo round($metrics['system_status']['memory_usage'] / 1024 / 1024, 2); ?> MB
                                </span>
                            </div>
                            <div class="status-item">
                                <h6>Last Updated</h6>
                                <span class="badge bg-primary"><?php echo $metrics['system_status']['last_update']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- After System Status section and before Recent Transactions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="api-status-card">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0">
                            <i class="bi bi-hdd-network me-2"></i>
                            API Status
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <?php foreach ($api_status as $name => $info): ?>
                            <div class="api-endpoint">
                                <div class="api-path">../API/<?php echo htmlspecialchars($name); ?>.php</div>
                                <div class="status-indicator status-<?php echo $info['status']; ?>">
                                    <?php if ($info['status'] === 'ok'): ?>
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>OK</span>
                                    <?php else: ?>
                                        <i class="bi bi-x-circle-fill"></i>
                                        <span>Error</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="row">
            <div class="col-12">
                <div class="card dashboard-card">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Transactions</h5>
                        <span class="badge bg-primary"><?php echo count($metrics['recent_transactions']); ?> latest</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($metrics['recent_transactions'] as $transaction): ?>
                                        <tr>
                                            <td><?php echo date('M d, H:i', strtotime($transaction['created_at'])); ?></td>
                                            <td>
                                                <span class="badge bg-<?php 
                                                    echo match($transaction['type']) {
                                                        'purchase' => 'success',
                                                        'refund' => 'warning',
                                                        'cancel' => 'danger',
                                                        default => 'secondary'
                                                    };
                                                ?>">
                                                    <?php echo ucfirst($transaction['type']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($transaction['customer_name'] ?? 'N/A'); ?></td>
                                            <td>
                                                <?php echo htmlspecialchars($transaction['product_name'] ?? 'N/A'); ?>
                                                <?php if (isset($transaction['current_stock']) && $transaction['current_stock'] < 5): ?>
                                                    <span class="badge bg-danger">Low Stock</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($transaction['payment_method'] ?? 'N/A'); ?></td>
                                            <td>
                                                <span class="badge status-<?php 
                                                    echo strtolower($transaction['status']); 
                                                ?> <?php 
                                                    if ($transaction['type'] === 'refund' || $transaction['status'] === 'refunded') {
                                                        echo 'status-refunded';
                                                    }
                                                ?>">
                                                    <?php 
                                                    if ($transaction['type'] === 'refund' || $transaction['status'] === 'refunded') {
                                                        echo 'REFUNDED';
                                                    } else {
                                                        echo ucfirst($transaction['status']); 
                                                    }
                                                    ?>
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <?php if ($transaction['type'] === 'refund'): ?>
                                                    <span class="text-danger">-</span>
                                                <?php endif; ?>
                                                ₱<?php echo number_format($transaction['amount'], 2); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Refresh Button -->
        <button class="refresh-button" onclick="location.reload()" title="Refresh Dashboard">
            <i class="bi bi-arrow-clockwise"></i>
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-focus the barcode input when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            const barcodeInput = document.querySelector('input[name="barcode"]');
            if (barcodeInput) {
                barcodeInput.focus();
            }
        });

        // Auto refresh every 30 seconds
        setTimeout(function() {
            location.reload();
        }, 30000);

        // Add loading animation when refreshing
        document.querySelector('.refresh-button').addEventListener('click', function() {
            this.classList.add('rotating');
        });
    </script>
</body>
</html>