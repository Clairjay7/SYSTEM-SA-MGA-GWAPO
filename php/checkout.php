<?php
session_start();

// Redirect if not logged in or not guest
if (!isset($_SESSION['user_id']) && !isset($_SESSION['guest'])) {
    header("Location: ../php/index.php");
    exit();
}

// Product data (ideally from DB)
$products = [
        ['id' => 1, 'name' => 'Hot Wheels 1997 FE Lamborghini Countach Yellow 25th Ann.', 'price' => 100.75, 'image_url' => 'https://i.ebayimg.com/images/g/VgcAAeSwunZnoqL~/s-l960.webp'],
        ['id' => 2, 'name' => 'Hot Wheels 1999 Ferrari F355 Berlinetta Red 5SP', 'price' => 1000.75, 'image_url' => 'https://i.ebayimg.com/images/g/iYcAAeSwCPtno9af/s-l960.webp'],
        ['id' => 3, 'name' => 'Hot Wheels 2000 Lamborghini Diablo Blue 5DOT Virtual Cars', 'price' => 555.75, 'image_url' => 'https://i.ebayimg.com/images/g/~KUAAOSwnEFfyX5~/s-l500.webp'],
        ['id' => 4, 'name' => 'Hot Wheels 1995 Nissan Skyline GT-R', 'price' => 250.50, 'image_url' => 'https://i.ebayimg.com/images/g/u8QAAeSwu~Jn25XQ/s-l500.webp'],
        ['id' => 5, 'name' => 'Hot Wheels 2020 Ford Mustang GT', 'price' => 450.99, 'image_url' => 'https://i.ebayimg.com/images/g/nBEAAOSwjaZn7Ghc/s-l500.webp'],
        ['id' => 6, 'name' => 'Hot Wheels Batmobile', 'price' => 300.00, 'image_url' => 'https://i.ebayimg.com/images/g/0~sAAOSwbqBgdmj-/s-l500.webp'],
        ['id' => 7, 'name' => 'Hot Wheels McLaren P1', 'price' => 650.00, 'image_url' => 'https://i.ebayimg.com/images/g/2RUAAOSwEdtndLbG/s-l1600.webp'],
        ['id' => 8, 'name' => 'Hot Wheels Porsche 911 Turbo', 'price' => 380.75, 'image_url' => 'https://i.ebayimg.com/images/g/Zh8AAeSwYWxn8Mgg/s-l1600.webp'],
        ['id' => 9, 'name' => 'Hot Wheels Toyota Supra A80', 'price' => 420.25, 'image_url' => 'https://i.ebayimg.com/images/g/p9oAAOSw1LpnxSfv/s-l1600.webp'],
        ['id' => 10, 'name' => 'Hot Wheels 1994 Mazda RX-7', 'price' => 550.00, 'image_url' => 'https://i.ebayimg.com/images/g/pOkAAOSwNQNl-4Ng/s-l1600.webp'],
        ['id' => 11, 'name' => 'Hot Wheels Dodge Viper GTS', 'price' => 700.50, 'image_url' => 'https://i.ebayimg.com/images/g/eeIAAeSwyvBn8McZ/s-l1600.webp'],
        ['id' => 12, 'name' => 'Hot Wheels 1969 Camaro Z28', 'price' => 320.00, 'image_url' => 'https://i.ebayimg.com/images/g/H3EAAOSwjYVmoeH1/s-l1600.webp'],
        ['id' => 13, 'name' => 'Hot Wheels Ferrari 512 TR', 'price' => 850.75, 'image_url' => 'https://i.ebayimg.com/images/g/-9YAAOSwF61mS5C7/s-l1600.webp'],
        ['id' => 14, 'name' => 'Hot Wheels Pagani Huayra', 'price' => 950.99, 'image_url' => 'https://i.ebayimg.com/images/g/EL8AAeSw8gxn07r7/s-l960.webp'],
        ['id' => 15, 'name' => 'Hot Wheels Chevrolet Corvette ZR1', 'price' => 760.00, 'image_url' => 'https://i.ebayimg.com/images/g/XWUAAOSwOVRnozkp/s-l1600.webp'],
        ['id' => 16, 'name' => 'Hot Wheels Aston Martin DB11', 'price' => 600.25, 'image_url' => 'https://i.ebayimg.com/images/g/BoYAAeSwegVn68LO/s-l1600.webp'],
        ['id' => 17, 'name' => 'Hot Wheels Shelby GT500 Mustang', 'price' => 670.00, 'image_url' => 'https://i.ebayimg.com/images/g/nBEAAOSwjaZn7Ghc/s-l1600.webp'],
        ['id' => 18, 'name' => 'Hot Wheels Dodge Charger RT', 'price' => 440.99, 'image_url' => 'https://i.ebayimg.com/images/g/XQ8AAOSw~oJnerHf/s-l1600.webp'],
        ['id' => 19, 'name' => 'Hot Wheels BMW M3 E30', 'price' => 500.00, 'image_url' => 'https://i.ebayimg.com/images/g/KOQAAOSwea5nxcJz/s-l1600.webp'],
        ['id' => 20, 'name' => 'Hot Wheels Subaru Impreza WRX STI', 'price' => 580.00, 'image_url' => 'https://i.ebayimg.com/images/g/N4cAAOSwKj5ncIoe/s-l1600.webp'],
        ['id' => 21, 'name' => 'Hot Wheels Ferrari 488 GTB', 'price' => 700.99, 'image_url' => 'https://i.ebayimg.com/images/g/BfMAAOSwMKdko7BH/s-l1600.webp'],
        ['id' => 22, 'name' => 'Hot Wheels Bugatti Chiron', 'price' => 1200.00, 'image_url' => 'https://i.ebayimg.com/images/g/VfcAAOSwfDVn1BD4/s-l1600.webp'],
        ['id' => 23, 'name' => 'Hot Wheels Audi R8 V10', 'price' => 800.00, 'image_url' => 'https://i.ebayimg.com/images/g/ScgAAOSwR7Blaecl/s-l1600.webp'],
        ['id' => 24, 'name' => 'Hot Wheels Lamborghini Huracan', 'price' => 900.00, 'image_url' => 'https://i.ebayimg.com/images/g/vw8AAOSwshhnchkQ/s-l1600.webp']
    ];

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product = null;

    foreach ($products as $p) {
        if ($p['id'] == $product_id) {
            $product = $p;
            break;
        }
    }

    if ($product) {
        $product_name = htmlspecialchars($product['name']);
        $product_price = number_format($product['price'], 2);
        $product_image = htmlspecialchars($product['image_url']);
    } else {
        echo "Product not found!";
        exit();
    }
} else {
    echo "No product selected!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Hot Wheels Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/checkout.css">
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar">
    <h1>Hapart 4 Speed</h1>
    <ul>
        <li><a href="../php/homepage.php">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="shop.php">Shop</a></li>
        <?php if (isset($_SESSION['user_id']) || isset($_SESSION['guest'])): ?>
            <li><a href="../php/logout.php">Logout</a></li>
        <?php endif; ?>
    </ul>
</nav>

<div class="checkout-container">
    <h2>Checkout</h2>

    <!-- Product Summary -->
    <div class="product-summary">
        <img src="<?= $product_image; ?>" alt="<?= $product_name; ?>">
        <h3><?= $product_name; ?></h3>
        <p>$<?= $product_price; ?></p>
    </div>

    <!-- Checkout Form -->
    <form class="checkout-form" action="process_checkout.php" method="POST">
        <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
        <input type="hidden" name="product_name" value="<?= $product_name; ?>">
        <input type="hidden" name="product_price" value="<?= $product_price; ?>">

        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" value="1" required>
        </div>

        <div class="form-group">
            <label for="payment_method">Payment Method:</label>
            <select name="payment_method" id="payment_method" required>
                <option value="">-- Select Payment Method --</option>
                <option value="Gcash">Gcash</option>
                <option value="Paypal">Paypal</option>
                <option value="Cash">Cash</option>
            </select>
        </div>

        <button type="submit" class="btn-submit">Complete Purchase</button>
    </form>

    <div class="back-home-container">
        <a href="shop.php" class="btn-back-home">← Back to Shop</a>
    </div>
</div>

</body>
</html>
