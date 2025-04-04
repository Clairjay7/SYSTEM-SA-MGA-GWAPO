<?php
session_start();
include 'connect.php'; // Connect sa database

// Check if order ID is provided
if (!isset($_GET['order_id'])) {
    header("Location: homepage.php");
    exit();
}

$orderId = $_GET['order_id'];

// Retrieve order details from the database
try {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->bindParam(1, $orderId, PDO::PARAM_INT);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        die("Order not found.");
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <link rel="stylesheet" href="receipt.css">
</head>
<body>
    <div class="receipt-container">
        <h2>Order Receipt</h2>
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['id']); ?></p>
        <p><strong>Product:</strong> <?php echo htmlspecialchars($order['product_name']); ?></p>
        <p><strong>Price:</strong> $<?php echo htmlspecialchars($order['price']); ?></p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($order['name']); ?></p>
        <p><strong>Payment Method:</strong> 
            <?php 
                // Display payment method in a readable format based on the database value
                switch($order['payment_method']) {
                    case 'Gcash':
                        echo "Gcash";
                        break;
                    case 'PayPal':
                        echo "PayPal";
                        break;
                    case 'Cash':
                        echo "Cash";
                        break;
                    default:
                        echo "Unknown payment method";
                }
            ?>
        </p>
        <button onclick="window.location.href='homepage.php'">Go to Homepage</button>
    </div>
</body>
</html>
