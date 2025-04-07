<?php
// Get product ID from URL
$product_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Dummy data for the example (replace with database query)
$products = [
    1 => [
        "name" => "Hot Wheels 1997 FE Lamborghini Countach Yellow 25th Ann.",
        "price" => 100.75,
        "description" => "A rare Lamborghini Countach model.",
        "image" => "https://i.ebayimg.com/images/g/VgcAAeSwunZnoqL~/s-l960.webp"
    ],
    2 => [
        "name" => "Hot Wheels 1999 Ferrari F355 Berlinetta Red 5SP",
        "price" => 1000.75,
        "description" => "A highly detailed Ferrari model.",
        "image" => "https://i.ebayimg.com/images/g/iYcAAeSwCPtno9af/s-l960.webp"
    ],
    3 => [
        "name" => "Hot Wheels 2000 Lamborghini Diablo Blue 5DOT Virtual Cars",
        "price" => 555.75,
        "description" => "A collectible Lamborghini Diablo model.",
        "image" => "https://i.ebayimg.com/images/g/~KUAAOSwnEFfyX5~/s-l500.webp"
    ],
    4 => [
        "name" => "Hot Wheels 1995 Nissan Skyline GT-R",
        "price" => 250.50,
        "description" => "A stunning Nissan Skyline GT-R model.",
        "image" => "https://i.ebayimg.com/images/g/u8QAAeSwu~Jn25XQ/s-l500.webp"
    ],
    5 => [
        "name" => "Hot Wheels 2020 Ford Mustang GT",
        "price" => 450.99,
        "description" => "A sleek Ford Mustang GT model.",
        "image" => "https://i.ebayimg.com/images/g/nBEAAOSwjaZn7Ghc/s-l500.webp"
    ],
    6 => [
        "name" => "Hot Wheels Batmobile",
        "price" => 300.00,
        "description" => "The iconic Batmobile model.",
        "image" => "https://i.ebayimg.com/images/g/0~sAAOSwbqBgdmj-/s-l500.webp"
    ],
    7 => [
        "name" => "Hot Wheels McLaren P1",
        "price" => 650.00,
        "description" => "A limited edition McLaren P1 model.",
        "image" => "https://i.ebayimg.com/images/g/2RUAAOSwEdtndLbG/s-l1600.webp"
    ],
    8 => [
        "name" => "Hot Wheels Porsche 911 Turbo",
        "price" => 380.75,
        "description" => "A detailed Porsche 911 Turbo model.",
        "image" => "https://i.ebayimg.com/images/g/Zh8AAeSwYWxn8Mgg/s-l1600.webp"
    ],
    9 => [
        "name" => "Hot Wheels Toyota Supra A80",
        "price" => 420.25,
        "description" => "A collectible Toyota Supra A80 model.",
        "image" => "https://i.ebayimg.com/images/g/p9oAAOSw1LpnxSfv/s-l1600.webp"
    ],
    10 => [
        "name" => "Hot Wheels 1994 Mazda RX-7",
        "price" => 550.00,
        "description" => "A rare Mazda RX-7 model.",
        "image" => "https://i.ebayimg.com/images/g/pOkAAOSwNQNl-4Ng/s-l1600.webp"
    ],
    11 => [
        "name" => "Hot Wheels Dodge Viper GTS",
        "price" => 700.00,
        "description" => "wow.",
        "image" => "https://i.ebayimg.com/images/g/eeIAAeSwyvBn8McZ/s-l1600.webp"
    ],
    12 => [
        "name" => "Hot Wheels 1969 Camaro Z28",
        "price" => 320.00,
        "description" => "wow.",
        "image" => "https://i.ebayimg.com/images/g/H3EAAOSwjYVmoeH1/s-l1600.webp"
    ],
    13 => [
        "name" => "Hot Wheels Ferrari 512 TR",
        "price" => 850.75,
        "description" => "wow.",
        "image" => "https://i.ebayimg.com/images/g/-9YAAOSwF61mS5C7/s-l1600.webp"
    ],
    14 => [
        "name" => "Hot Wheels Pagani Huayra",
        "price" => 950.99,
        "description" => "wow.",
        "image" => "https://i.ebayimg.com/images/g/EL8AAeSw8gxn07r7/s-l960.webp"
    ],
    15 => [
        "name" => "Hot Wheels Chevrolet Corvette ZR1",
        "price" => 760.00,
        "description" => "wow.",
        "image" => "https://i.ebayimg.com/images/g/XWUAAOSwOVRnozkp/s-l1600.webp"
    ],
    16 => [
        "name" => "Hot Wheels Aston Martin DB11",
        "price" => 600.25,
        "description" => "wow.",
        "image" => "https://i.ebayimg.com/images/g/BoYAAeSwegVn68LO/s-l1600.webp"
    ],
    17 => [
        "name" => "Hot Wheels Shelby GT500 Mustang",
        "price" => 670.00,
        "description" => "wow.",
        "image" => "https://i.ebayimg.com/images/g/nBEAAOSwjaZn7Ghc/s-l1600.webp"
    ],
    18 => [
        "name" => "Hot Wheels Dodge Charger RT",
        "price" => 449.99,
        "description" => "wow.",
        "image" => "https://i.ebayimg.com/images/g/XQ8AAOSw~oJnerHf/s-l1600.webp"
    ],
    19 => [
        "name" => "Hot Wheels BMW M3 E30",
        "price" => 500.00,
        "description" => "wow.",
        "image" => "https://i.ebayimg.com/images/g/KOQAAOSwea5nxcJz/s-l1600.webp"
    ],
    20 => [
        "name" => "Hot Wheels Subaru Impreza WRX STI",
        "price" => 580.00,
        "description" => "wow.",
        "image" => "https://i.ebayimg.com/images/g/N4cAAOSwKj5ncIoe/s-l1600.webp"
    ],
    21 => [
        "name" => "Hot Wheels Ferrari 488 GTB",
        "price" => 700.99,
        "description" => "wow.",
        "image" => "https://i.ebayimg.com/images/g/BfMAAOSwMKdko7BH/s-l1600.webp"
    ],
    22 => [
        "name" => "Hot Wheels Bugatti Chiron",
        "price" => 1200.00,
        "description" => "wow.",
        "image" => "https://i.ebayimg.com/images/g/VfcAAOSwfDVn1BD4/s-l1600.webp"
    ],
    23 => [
        "name" => "HHot Wheels Audi R8 V10",
        "price" => 800.00,
        "description" => "wow.",
        "image" => "https://i.ebayimg.com/images/g/ScgAAOSwR7Blaecl/s-l1600.webp"
    ],
    24 => [
        "name" => "Hot Wheels Lamborghini Huracan",
        "price" => 900.00,
        "description" => "wow.",
        "image" => "https://i.ebayimg.com/images/g/vw8AAOSwshhnchkQ/s-l1600.webp"
    ],


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
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="logout.php">Logout</a></li>
            <?php if (isset($_SESSION['user_id']) || isset($_SESSION['guest'])): ?>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="product-detail-container">
        <h2><?= htmlspecialchars($product['name']); ?></h2>
        <img src="<?= $product['image']; ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="product-image" />
        <p><?= htmlspecialchars($product['description']); ?></p>
        <p class="price">$<?= number_format($product['price'], 2); ?></p>
    </div>
</body>
</html>
