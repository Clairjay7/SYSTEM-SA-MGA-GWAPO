<?php
session_start();
require_once '../config/database.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

error_log("Receipt page accessed");
error_log("Session data: " . print_r($_SESSION, true));

// Check if there's order data in session
if (!isset($_SESSION['order_details'])) {
    error_log("No order details in session");
    header("Location: shop.php");
    exit();
}

$order = $_SESSION['order_details'];
error_log("Order details retrieved: " . print_r($order, true));

// Clear the order details from session immediately
unset($_SESSION['order_details']);
session_write_close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt - Hot Wheels Store</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <style>
        .receipt-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #eee;
        }
        .receipt-details {
            margin: 1rem 0;
        }
        .receipt-details p {
            margin: 0.5rem 0;
            font-size: 1.1rem;
        }
        .receipt-total {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .receipt-footer {
            margin-top: 2rem;
            text-align: center;
        }
        .btn-back {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #ff4500;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 1rem;
        }
        .btn-back:hover {
            background: #ff6f00;
        }
        .order-id {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 1rem;
        }
        @media print {
            .navbar, .btn-back {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <h1>Hot Wheels Store</h1>
        <ul>
            <li><a href="shop.php">Back to Shop</a></li>
            <?php if (isset($_SESSION['user_id']) || isset($_SESSION['guest'])): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="receipt-container">
        <div class="receipt-header">
            <h2>Order Receipt</h2>
            <p class="order-id">Order ID: <?= htmlspecialchars($order['order_id']) ?></p>
            <p><?= date('F j, Y g:i A') ?></p>
        </div>

        <div class="receipt-details">
            <p><strong>Customer Name:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
            <p><strong>Product:</strong> <?= htmlspecialchars($order['product_name']) ?></p>
            <p><strong>Quantity:</strong> <?= htmlspecialchars($order['quantity']) ?></p>
            <p><strong>Price per item:</strong> $<?= number_format($order['price'], 2) ?></p>
            <p><strong>Payment Method:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
            
            <div class="receipt-total">
                <p><strong>Total Amount:</strong> $<?= number_format($order['total_amount'], 2) ?></p>
            </div>
        </div>

        <div class="receipt-footer">
            <p>Thank you for shopping with Hot Wheels Store!</p>
            <p>Please keep this receipt for your records.</p>
            <a href="shop.php" class="btn-back">Continue Shopping</a>
        </div>
    </div>

    <script>
        // Prevent going back to checkout page
        window.history.pushState(null, '', window.location.href);
        window.addEventListener('popstate', function() {
            window.location.href = 'shop.php';
        });
    </script>
</body>
</html>
