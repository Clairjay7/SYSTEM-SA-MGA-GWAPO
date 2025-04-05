<?php
session_start();
<<<<<<< HEAD

// Check if the user is logged in or a guest
if (!isset($_SESSION['user_id']) && !isset($_SESSION['guest'])) {
    header("Location: ../php/index.php"); // Redirect to homepage if not logged in
    exit();
}

// Static product array (should ideally come from a database in a real application)
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


// Check if product_id is passed via POST
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Find the product matching the ID
    $product = null;
    foreach ($products as $p) {
        if ($p['id'] == $product_id) {
            $product = $p;
            break;
        }
    }

    // If product is found, display its details
    if ($product) {
        $product_name = htmlspecialchars($product['name']);
        $product_price = number_format($product['price'], 2);
        $product_image = htmlspecialchars($product['image_url']);
    } else {
        // Product not found, handle error
        echo "Product not found!";
        exit();
    }
} else {
    // Handle case where no product ID is passed
    echo "No product selected!";
=======
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

>>>>>>> c739b7baacb2d2ed47c87c308876a7249c13214a
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Hot Wheels Store</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/checkout.css">
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

    <div class="checkout-container">
        <h2>Checkout</h2>

        <!-- Product Details -->
        <div class="checkout-details">
            <img src="<?= $product_image; ?>" alt="<?= $product_name; ?>" class="product-image">
            <h3><?= $product_name; ?></h3>
            <p class="product-price">$<?= $product_price; ?></p>
        </div>

        <!-- Checkout Form -->
        <form action="process_checkout.php" method="POST">
            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
            <input type="hidden" name="product_name" value="<?= $product_name; ?>">
            <input type="hidden" name="product_price" value="<?= $product_price; ?>">

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" min="1" value="1" required>
            <br><br>

            <label for="payment_method">Payment Method:</label>
            <select name="payment_method" id="payment_method" required>
                <option value="">-- Select Payment Method --</option>
                <option value="Gcash">Gcash</option>
                <option value="Paypal">Paypal</option>
                <option value="Cash">Cash</option>
            </select>

            

            
            <br><br>

            <input type="submit" value="Complete Purchase" class="btn">
        </form>

    </div>

</body>

=======
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
>>>>>>> c739b7baacb2d2ed47c87c308876a7249c13214a
</html>
