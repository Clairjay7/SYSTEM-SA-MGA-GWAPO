<?php
session_start();
require_once '../config/database.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in or is a guest
if (!isset($_SESSION['user_id']) && !isset($_SESSION['guest'])) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_POST['product_id']) || !isset($_POST['name']) || !isset($_POST['price'])) {
    header("Location: shop.php");
    exit();
}

$product_id = $_POST['product_id'];
$product_name = $_POST['name'];
$product_price = $_POST['price'];

// Get product details
try {
    $stmt = $pdo->prepare("SELECT * FROM inventory WHERE id = ? AND quantity > 0");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if (!$product) {
        $_SESSION['error'] = "Product not available";
        header("Location: shop.php");
        exit();
    }
} catch(PDOException $e) {
    $_SESSION['error'] = "Error fetching product: " . $e->getMessage();
    header("Location: shop.php");
    exit();
}

// Check if there's an error message
$error_msg = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']); // Clear the error message after displaying
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - HOT4HAPART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/homepage.css">
    <link rel="stylesheet" href="../css/checkout.css">
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
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Shop</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id']) || isset($_SESSION['guest'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="checkout-container">
        <?php if ($error_msg): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error_msg) ?>
            </div>
        <?php endif; ?>

        <div class="checkout-card">
            <div class="product-summary">
                <img src="<?= htmlspecialchars($product['image_url']); ?>" alt="<?= htmlspecialchars($product_name); ?>" class="product-image">
                <h2><?= htmlspecialchars($product_name); ?></h2>
                <p class="product-price">₱<?= number_format($product_price, 2); ?></p>
            </div>

            <form class="checkout-form" action="process_checkout.php" method="POST" id="checkoutForm">
                <input type="hidden" name="product_id" value="<?= $product_id; ?>">
                <input type="hidden" name="name" value="<?= htmlspecialchars($product_name); ?>">
                <input type="hidden" name="price" value="<?= $product_price; ?>">

                <div class="form-group mb-3">
                    <label for="quantity" class="form-label">Quantity:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="<?= $product['quantity']; ?>" value="1" required>
                </div>

                <div class="form-group mb-3">
                    <label for="customer_name" class="form-label">Your Name:</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                </div>

                <div class="form-group mb-3">
                    <label for="payment_method" class="form-label">Payment Method:</label>
                    <select name="payment_method" id="payment_method" class="form-select" required>
                        <option value="">-- Select Payment Method --</option>
                        <option value="Cash">Cash</option>
                        <option value="Gcash">Gcash</option>
                        <option value="Paypal">Paypal</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100" id="submitBtn">Complete Purchase</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing...';
            this.submit();
        });
    </script>
</body>
</html> 