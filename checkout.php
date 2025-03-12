<?php
session_start();
include 'connect.php'; // Connect sa database

// CSRF Token Generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check if product details are set
if (!isset($_GET['name'], $_GET['price'], $_GET['image'])) {
    header("Location: shop.php");
    exit();
}

$productName = urldecode($_GET['name']);
$productPrice = urldecode($_GET['price']);
$productImage = urldecode($_GET['image']);

// Process order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid request");
    }

    $name = $_POST['name'];
    $address = $_POST['address'];
    $payment = $_POST['payment'];

    // Ipasok ang order sa database
    $stmt = $conn->prepare("INSERT INTO orders (name, address, payment_method, product_name, price) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $name, $address, $payment, $productName, $productPrice);

    if ($stmt->execute()) {
        echo "<script>alert('Order placed successfully!'); window.location.href='homepage.php';</script>";
    } else {
        echo "<script>alert('Error placing order.');</script>";
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="checkout.css">
</head>
<body>
    <div class="checkout-container">
        <h2>Checkout</h2>
        <div class="product-summary">
            <img src="<?php echo htmlspecialchars($productImage); ?>" alt="Product Image">
            <h3><?php echo htmlspecialchars($productName); ?></h3>
            <p>Price: $<?php echo htmlspecialchars($productPrice); ?></p>
        </div>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <!-- Full Name Input -->
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <!-- Shipping Address Input (Fixed) -->
            <div class="form-group">
                <label for="address">Shipping Address:</label>
                <input type="text" id="address" name="address" required>
            </div>

            <!-- Payment Method Dropdown -->
            <div class="form-group">
                <label for="payment">Payment Method:</label>
                <select id="payment" name="payment" required>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="cod">Cash on Delivery</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit">Place Order</button>
        </form>
        <button onclick="window.location.href='homepage.php'">Cancel</button>
    </div>
</body>
</html>
