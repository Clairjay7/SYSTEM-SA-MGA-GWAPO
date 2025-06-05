<?php
session_start();
require_once '../config/database.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

error_log("Receipt page accessed");
error_log("Session data: " . print_r($_SESSION, true));

// Check if order_id is provided
if (!isset($_GET['order_id'])) {
    header('Location: shop.php');
    exit();
}

$order_id = $_GET['order_id'];

// Fetch order details
try {
    $stmt = $pdo->prepare("
        SELECT o.*, i.name as product_name 
        FROM orders o
        JOIN inventory i ON o.product_id = i.id
        WHERE o.id = ?
    ");
    $stmt->execute([$order_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        $_SESSION['error'] = "Order not found";
        header('Location: shop.php');
        exit();
    }

} catch (PDOException $e) {
    $_SESSION['error'] = "Error fetching order details: " . $e->getMessage();
    header('Location: shop.php');
    exit();
}

// Calculate total
$total_amount = $order['quantity'] * $order['price'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt - HOT4HAPART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/homepage.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, #e31837 0%, #c41230 100%);
        }

        .navbar-brand {
            color: white;
            font-weight: bold;
        }

        .nav-link {
            color: white !important;
        }

        .shop-header {
            background: linear-gradient(135deg, #e31837 0%, #c41230 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 40px;
        }
        
        .shop-header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .shop-content {
            flex: 1;
        }
        
        .shop-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .shop-description {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .shop-logo {
            max-width: 200px;
            margin-left: 40px;
        }

        .receipt-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
            margin: -60px auto 3rem;
            max-width: 800px;
            padding: 1.5rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .receipt-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .order-id {
            color: #666;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .receipt-details {
            margin: 1.5rem 0;
        }

        .receipt-details p {
            align-items: center;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            margin: 0.5rem 0;
            padding: 0.5rem 0;
            font-size: 0.95rem;
            color: #333;
        }

        .receipt-details strong {
            font-weight: 600;
        }

        .receipt-total {
            background: #f8f9fa;
            border-radius: 6px;
            margin-top: 1.5rem;
            padding: 1rem;
        }

        .receipt-total p {
            align-items: center;
            color: #e31837;
            display: flex;
            font-size: 1.2rem;
            font-weight: 600;
            justify-content: space-between;
            margin: 0;
        }

        .receipt-footer {
            border-top: 1px solid #eee;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            text-align: center;
        }

        .receipt-footer p {
            color: #666;
            font-size: 0.9rem;
            margin: 0.5rem 0;
        }

        .d-grid {
            display: grid;
            gap: 0.5rem;
        }

        .btn-back {
            background: #e31837;
            border: none;
            border-radius: 4px;
            color: white;
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            text-align: center;
            text-decoration: none;
            text-transform: uppercase;
            transition: background-color 0.2s ease;
            width: 100%;
        }

        .btn-outline-primary {
            background: transparent;
            border: 1px solid #0d6efd;
            border-radius: 4px;
            color: #0d6efd;
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s ease;
            width: 100%;
        }

        .btn-outline-primary:hover {
            background: #0d6efd;
            color: white;
            text-decoration: none;
        }

        .btn-back:hover {
            background: #c41230;
            color: white;
            text-decoration: none;
        }

        @media print {
            .navbar, .btn-back {
                display: none;
            }
            body {
                background: white;
            }
            .receipt-container {
                box-shadow: none;
                margin: 0;
                padding: 20px;
            }
            .shop-header {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="homepage.php">HOT4HAPART</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="homepage.php">Home</a>
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

    <!-- Receipt Header -->
    <header class="shop-header">
        <div class="container">
            <div class="shop-content">
                <h1 class="shop-title">Order Receipt</h1>
                <p class="shop-description">Thank you for your purchase at HOT4HAPART</p>
            </div>
            <img src="../grrr.png" alt="HOT4HAPART Logo" class="shop-logo">
        </div>
    </header>

    <div class="container">
        <div class="receipt-container">
            <div class="order-id">Order ID: <?php echo htmlspecialchars($order_id); ?></div>
            <p class="text-muted text-center mb-4"><?php echo date('F j, Y g:i A', strtotime($order['created_at'])); ?></p>

            <div class="receipt-details">
                <p>
                    <strong>Customer Name:</strong> 
                    <span><?php echo htmlspecialchars($order['customer_name']); ?></span>
                </p>
                <?php if (isset($order['customer_email']) && !empty($order['customer_email'])): ?>
                <p>
                    <strong>Email:</strong>
                    <span><?php echo htmlspecialchars($order['customer_email']); ?></span>
                </p>
                <?php endif; ?>
                <?php if (isset($order['customer_phone']) && !empty($order['customer_phone'])): ?>
                <p>
                    <strong>Phone:</strong>
                    <span><?php echo htmlspecialchars($order['customer_phone']); ?></span>
                </p>
                <?php endif; ?>
                <?php if (isset($order['shipping_address']) && !empty($order['shipping_address'])): ?>
                <p>
                    <strong>Shipping Address:</strong>
                    <span><?php echo htmlspecialchars($order['shipping_address']); ?></span>
                </p>
                <?php endif; ?>
                <p>
                    <strong>Product:</strong>
                    <span><?php echo htmlspecialchars($order['product_name']); ?></span>
                </p>
                <p>
                    <strong>Quantity:</strong>
                    <span><?php echo htmlspecialchars($order['quantity']); ?></span>
                </p>
                <p>
                    <strong>Price per item:</strong>
                    <span>₱<?php echo number_format($order['price'], 2); ?></span>
                </p>
                <p>
                    <strong>Payment Method:</strong>
                    <span><?php echo htmlspecialchars($order['payment_method']); ?></span>
                </p>
                
                <div class="receipt-total">
                    <p>
                        <strong>Total Amount:</strong>
                        <span>₱<?php echo number_format($total_amount, 2); ?></span>
                    </p>
                </div>
            </div>

            <div class="receipt-footer">
                <p>Thank you for shopping with HOT4HAPART!</p>
                <p>Please keep this receipt for your records.</p>
                <div class="d-grid gap-2">
                    <a href="shop.php" class="btn-outline-primary">Back to Shop</a>
                    <a href="#" onclick="window.print()" class="btn-back">Print Receipt</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Prevent going back to checkout page
        window.history.pushState(null, '', window.location.href);
        window.addEventListener('popstate', function() {
            window.location.href = 'shop.php';
        });
    </script>
</body>
</html>
