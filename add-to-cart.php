<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Added to Cart</title>
    <link rel="stylesheet" href="add-to-cart.css"> <!-- Linked CSS file -->
</head>
<body>

<div class="container">
    <?php
    if (isset($_GET['name']) && isset($_GET['price']) && isset($_GET['image'])) {
        $product = [
            'name' => $_GET['name'],
            'price' => $_GET['price'],
            'image' => $_GET['image']
        ];

        // Store in session cart
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        $_SESSION['cart'][] = $product;
        ?>

        <h2>Item Added to Cart!</h2>
        <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" class="product-img">
        <p class="product-name"><?= htmlspecialchars($product['name']) ?></p>
        <p class="product-price"><?= htmlspecialchars($product['price']) ?></p>

        <div class="buttons">
            <a href="homepage.php" class="btn btn-primary">Continue Shopping</a>
            <a href="cart.php" class="btn btn-secondary">Go to Cart</a>
        </div>

    <?php
    } else {
        echo "<h2>No product selected.</h2>";
    }
    ?>
</div>

</body>
</html>
