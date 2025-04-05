<?php
session_start();
include '../php/connect.php'; // Ensure the connect.php file is included for database connection

// Check if order_id is provided
if (!isset($_GET['order_id'])) {
    echo "No order ID found.";
    exit();
}

$orderId = $_GET['order_id'];

// Fetch order details from the database
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bindParam(1, $orderId, PDO::PARAM_INT);
$stmt->execute();
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "Order not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="../css/receipt.css">
</head>
<body>
    <div class="receipt-container">
        <h2>Order Receipt</h2>

        <p><strong>Order ID:</strong> <?php echo $order['id']; ?></p>
        <p><strong>Customer Name:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
        <p><strong>Product:</strong> <?php echo htmlspecialchars($order['product_name']); ?></p>
        <p><strong>Quantity:</strong> <?php echo $order['quantity']; ?></p>
        <p><strong>Price:</strong> $<?php echo number_format($order['price'], 2); ?></p>
        
        <p><strong>Payment Method:</strong> 
            <?php 
                switch ($order['payment_method']) {
                    case 'Gcash':
                        echo 'Gcash';
                        break;
                    case 'Paypal':
                        echo 'Paypal';
                        break;
                    case 'Cash':
                        echo 'Cash'; // Just display 'Cash' without 'on Delivery' if 'Cash' is stored in the database
                        break;
                    default:
                        echo 'Unknown Payment Method';
                }
            ?>
        </p>

        <p><strong>Status:</strong> <?php echo $order['status']; ?></p>

        <h3>Thank you for your purchase!</h3>
        <a href="../php/homepage.php">Back to Homepage</a>
    </div>
</body>
</html>
