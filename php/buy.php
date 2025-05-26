<?php
session_start();
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    header("Location: homepage.php");
    exit();
}

$product_id = $_GET['id'];

// Get product details
try {
    $stmt = $pdo->prepare("SELECT id, name, description, price, quantity FROM inventory WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if (!$product) {
        header("Location: homepage.php");
        exit();
    }
} catch(PDOException $e) {
    die("Error fetching product: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = $_POST['quantity'];
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_phone = $_POST['customer_phone'];
    $shipping_address = $_POST['shipping_address'];
    $total_amount = $product['price'] * $quantity;

    try {
        $pdo->beginTransaction();

        // Create order
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_email, customer_phone, shipping_address, total_amount) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$customer_name, $customer_email, $customer_phone, $shipping_address, $total_amount]);
        $order_id = $pdo->lastInsertId();

        // Create order item
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price_per_unit) VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $product_id, $quantity, $product['price']]);

        // Update inventory quantity
        $stmt = $pdo->prepare("UPDATE inventory SET quantity = quantity - ? WHERE id = ? AND quantity >= ?");
        $result = $stmt->execute([$quantity, $product_id, $quantity]);

        if ($stmt->rowCount() === 0) {
            throw new Exception("Not enough stock available");
        }

        $pdo->commit();
        $_SESSION['success'] = "Order placed successfully!";
        header("Location: homepage.php");
        exit();
    } catch(Exception $e) {
        $pdo->rollBack();
        $error = "Error placing order: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Product - Galorpot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="homepage.php">Galorpot</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="homepage.php">Back to Products</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h2>Buy Product</h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>

                        <div class="mb-4">
                            <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                            <p><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="h5">Price: ₱<?php echo number_format($product['price'], 2); ?></p>
                            <p>Available Stock: <?php echo htmlspecialchars($product['quantity']); ?></p>
                        </div>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="<?php echo $product['quantity']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="customer_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                            </div>
                            <div class="mb-3">
                                <label for="customer_phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
                            </div>
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Shipping Address</label>
                                <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required></textarea>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Place Order</button>
                                <a href="homepage.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>