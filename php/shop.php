<?php
session_start();

// Check if the user is logged in or a guest
if (!isset($_SESSION['user_id']) && !isset($_SESSION['guest'])) {
    header("Location: ../php/index.php"); // Redirect to homepage if not logged in
    exit();
}

// Your static product array
$products = [
    ['id' => 1, 'name' => 'Hot Wheels 1997 FE Lamborghini Countach Yellow 25th Ann.', 'price' => 100.75, 'image_url' => 'https://i.ebayimg.com/images/g/VgcAAeSwunZnoqL~/s-l960.webp'],
    ['id' => 2, 'name' => 'Hot Wheels 1999 Ferrari F355 Berlinetta Red 5SP', 'price' => 1000.75, 'image_url' => 'https://i.ebayimg.com/images/g/iYcAAeSwCPtno9af/s-l960.webp'],
    ['id' => 3, 'name' => 'Hot Wheels 2000 Lamborghini Diablo Blue 5DOT Virtual Cars', 'price' => 555.75, 'image_url' => 'https://i.ebayimg.com/images/g/~KUAAOSwnEFfyX5~/s-l500.webp'],
    ['id' => 4, 'name' => 'Hot Wheels 1995 Nissan Skyline GT-R', 'price' => 250.50, 'image_url' => 'https://i.ebayimg.com/images/g/u8QAAeSwu~Jn25XQ/s-l500.webp'],
    ['id' => 5, 'name' => 'Hot Wheels 2020 Ford Mustang GT', 'price' => 450.99, 'image_url' => 'https://i.ebayimg.com/images/g/nBEAAOSwjaZn7Ghc/s-l500.webp'],
    ['id' => 6, 'name' => 'Hot Wheels Batmobile', 'price' => 300.00, 'image_url' => 'https://i.ebayimg.com/images/g/0~sAAOSwbqBgdmj-/s-l500.webp'],
    ['id' => 7, 'name' => 'Hot Wheels McLaren P1', 'price' => 650.00, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 8, 'name' => 'Hot Wheels Porsche 911 Turbo', 'price' => 380.75, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 9, 'name' => 'Hot Wheels Toyota Supra A80', 'price' => 420.25, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 10, 'name' => 'Hot Wheels 1994 Mazda RX-7', 'price' => 550.00, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 11, 'name' => 'Hot Wheels Dodge Viper GTS', 'price' => 700.50, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 12, 'name' => 'Hot Wheels 1969 Camaro Z28', 'price' => 320.00, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 13, 'name' => 'Hot Wheels Ferrari 512 TR', 'price' => 850.75, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 14, 'name' => 'Hot Wheels Pagani Huayra', 'price' => 950.99, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 15, 'name' => 'Hot Wheels Chevrolet Corvette ZR1', 'price' => 760.00, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 16, 'name' => 'Hot Wheels Aston Martin DB11', 'price' => 600.25, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 17, 'name' => 'Hot Wheels Shelby GT500 Mustang', 'price' => 670.00, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 18, 'name' => 'Hot Wheels Dodge Charger RT', 'price' => 440.99, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 19, 'name' => 'Hot Wheels BMW M3 E30', 'price' => 500.00, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 20, 'name' => 'Hot Wheels Subaru Impreza WRX STI', 'price' => 580.00, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 21, 'name' => 'Hot Wheels Ferrari 488 GTB', 'price' => 700.99, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 22, 'name' => 'Hot Wheels Bugatti Chiron', 'price' => 1200.00, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 23, 'name' => 'Hot Wheels Audi R8 V10', 'price' => 800.00, 'image_url' => 'https://via.placeholder.com/150'],
    ['id' => 24, 'name' => 'Hot Wheels Lamborghini Huracan', 'price' => 900.00, 'image_url' => 'https://via.placeholder.com/150']
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Hot Wheels Store</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/shop.css">
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <h1>Hapart 4 Speed</h1>
        <ul>
            <li><a href="../php/index.php">Home</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <?php if (isset($_SESSION['user_id']) || isset($_SESSION['guest'])): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="shop-container">
        <h2>Shop Our Hot Wheels Collection</h2>

        <!-- Product List -->
        <div class="product-list">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($product['image_url']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="product-image">
                    <h3><?= htmlspecialchars($product['name']); ?></h3>
                    <p class="product-price">$<?= number_format($product['price'], 2); ?></p>
                    <a href="product_details.php?id=<?= $product['id']; ?>" class="btn">View Details</a>
                    <form action="checkout.php" method="POST" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                        <button type="submit" class="btn">Buy</button>
                    </form>

                    
                    

                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>