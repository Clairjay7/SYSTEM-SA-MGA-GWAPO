<?php
// Get product ID from URL
$product_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Dummy data for the example (replace with database query)
$products = [
    1 => [
        "name" => "Hot Wheels 1997 FE Lamborghini Countach Yellow 25th Ann.",
        "price" => 100.75,
        "description" => "A rare Lamborghini Countach model.",
        "image" => "https://via.placeholder.com/500"
    ],
    2 => [
        "name" => "Hot Wheels 1999 Ferrari F355 Berlinetta Red 5SP",
        "price" => 1000.75,
        "description" => "A highly detailed Ferrari model.",
        "image" => "https://via.placeholder.com/500"
    ],
    3 => [
        "name" => "Hot Wheels 2000 Lamborghini Diablo Blue 5DOT Virtual Cars",
        "price" => 555.75,
        "description" => "A collectible Lamborghini Diablo model.",
        "image" => "https://via.placeholder.com/500"
    ]
];

$product = isset($products[$product_id]) ? $products[$product_id] : null;

if (!$product) {
    echo "Product not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']); ?> - Hot Wheels Store</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <h1>Hapart 4 Speed</h1>
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <?php if (isset($_SESSION['user_id']) || isset($_SESSION['guest'])): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="product-detail-container">
        <h2><?= htmlspecialchars($product['name']); ?></h2>
        <img src="<?= $product['image']; ?>" alt="<?= htmlspecialchars($product['name']); ?>" />
        <p><?= htmlspecialchars($product['description']); ?></p>
        <p class="price">$<?= number_format($product['price'], 2); ?></p>
    </div>
</body>
</html>
