<?php
session_start();
include '../php/connect.php'; // Connect sa database

// CSRF Token Generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check if product details are set
if (!isset($_GET['name'], $_GET['price'], $_GET['image'])) {
    header("Location: ../php/shop.php");
    exit();
}

$productName = urldecode($_GET['name']);
$productPrice = urldecode($_GET['price']);
$productImage = urldecode($_GET['image']);

// Process order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid request");
    }

    // Sanitize form inputs
    $name = htmlspecialchars($_POST['name']);
    $payment = htmlspecialchars($_POST['payment']);

    // Insert the order into the database using PDO
    try {
        $stmt = $pdo->prepare("INSERT INTO orders (name, payment_method, product_name, price) VALUES (?, ?, ?, ?)");
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $payment, PDO::PARAM_STR);
        $stmt->bindParam(3, $productName, PDO::PARAM_STR);
        $stmt->bindParam(4, $productPrice, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Get the order ID of the last inserted record
            $orderId = $pdo->lastInsertId();

            // Redirect to the receipt page with the order ID
            header("Location: ../php/receipt.php?order_id=" . $orderId);
            exit();
        } else {
            echo "<script>alert('Error placing order.');</script>";
        }

    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/checkout.css">
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

            <!-- Payment Method Dropdown -->
            <div class="form-group">
                <label for="payment">Payment Method:</label>
                <select id="payment" name="payment" required>
                    <option value="Gcash">Gcash</option>
                    <option value="PayPal">PayPal</option>
                    <option value="Cash">Cash</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit">Place Order</button>
        </form>
        <button onclick="window.location.href='../php/homepage.php'">Cancel</button>
    </div>
</body>
</html>
