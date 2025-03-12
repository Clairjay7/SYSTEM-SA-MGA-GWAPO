<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hot Wheels Store</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="script.js" defer></script>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <h1>Hapart 4 Speed</h1>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Shop</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href='logout.php'>Logout</a></li>
            <li><a href="getHelp.php" class="get-help-btn">Get Help</a></li>
            <li><a href="manageUsers.php">Manage Users</a></li> <!-- New Manage Users Link -->
        </ul>
    </nav>

    <div class="dashboard-container">
        <section class="dashboard-buttons">
            <button class="dashboard-btn" onclick="location.href='manageInventory.php'">Manage Inventory</button>
            <button class="dashboard-btn">Orders</button>
            <button class="dashboard-btn">Users</button>
            <button class="dashboard-btn">Settings</button>
        </section>

        <!-- Main Content -->
        <div class="main-content">
            <header class="hero-section">
                <h2>Welcome to the Ultimate Hot Wheels Collection</h2>
                <p>Discover, Collect, and Race with the Best Cars</p>
            </header>

            <!-- Products Section -->
            <section class="product-grid">

                <div class="product-card">
                    <img src="https://i.ebayimg.com/images/g/VgcAAeSwunZnoqL~/s-l960.webp" alt="Hot Wheels Car">
                    <h3>Hot Wheels 1997 FE Lamborghini Countach Yellow 25th Ann.</h3>
                    <p class="product-price">$15.75</p>
                    <div class="button-container">
                        <button class="btn view-details">View Details</button>
                        <button class="btn buy-button">Buy</button>
                    </div>
                </div>

                <div class="product-card">
                    <img src="https://i.ebayimg.com/images/g/iYcAAeSwCPtno9af/s-l960.webp" alt="Hot Wheels Car">
                    <h3>Hot Wheels 1999 Ferrari F355 Berlinetta Red 5SP</h3>
                    <p class="product-price">$15.75</p>
                    <div class="button-container">
                        <button class="btn view-details">View Details</button>
                        <button class="btn buy-button">Buy</button>
                    </div>
                </div>

                <div class="product-card">
                    <img src="https://i.ebayimg.com/images/g/6DoAAeSwQ71npOES/s-l960.webp" alt="Hot Wheels Car">
                    <h3>Hot Wheels 2000 Lamborghini Diablo Blue 5DOT Virtual Cars</h3>
                    <p class="product-price">$15.75</p>
                    <div class="button-container">
                        <button class="btn view-details">View Details</button>
                        <button class="btn buy-button">Buy</button>
                    </div>
                </div>

                <div class="product-card">
                    <img src="https://i.ebayimg.com/images/g/9w8AAeSwIIZnyFvK/s-l960.webp" alt="Hot Wheels Car">
                    <h3>2023 Hot Wheels DC Batmobile White Batman Series 3/5</h3>
                    <p class="product-price">$15.75</p>
                    <div class="button-container">
                        <button class="btn view-details">View Details</button>
                        <button class="btn buy-button">Buy</button>
                    </div>
                </div>

                <div class="product-card">
                    <img src="https://i.ebayimg.com/images/g/AcIAAeSwg8lnyG9o/s-l960.webp" alt="Hot Wheels Car">
                    <h3>2025 Hot Wheels Lamborghini Countach & Lancia Stratos</h3>
                    <p class="product-price">$15.75</p>
                    <div class="button-container">
                        <button class="btn view-details">View Details</button>
                        <button class="btn buy-button">Buy</button>
                    </div>
                </div>

                <div class="product-card">
                    <img src="https://i.ebayimg.com/images/g/LBwAAeSwUzNnyFr9/s-l500.webp" alt="Hot Wheels Car">
                    <h3>Hot Wheels City Downtown Aquarium Bash Set</h3>
                    <p class="product-price">$15.75</p>
                    <div class="button-container">
                        <button class="btn view-details">View Details</button>
                        <button class="btn buy-button">Buy</button>
                    </div>
                </div>

                <div class="product-card">
                    <img src="https://i.ebayimg.com/images/g/mzAAAOSw-rBnyG2f/s-l1600.webp" alt="Hot Wheels Car">
                    <h3>Monster Jam SPARKLE SMASH Rainbow Unicorn Truck 2 Pack</h3>
                    <p class="product-price">$15.75</p>
                    <div class="button-container">
                        <button class="btn view-details">View Details</button>
                        <button class="btn buy-button">Buy</button>
                    </div>
                </div>

                <div class="product-card">
                    <img src="https://i.ebayimg.com/images/g/UoYAAeSw~5lnyG4T/s-l960.webp" alt="Hot Wheels Car">
                    <h3>2025 Hot Wheels Premium Spoon Honda Civic Type R 2 Pack</h3>
                    <p class="product-price">$15.75</p>
                    <div class="button-container">
                        <button class="btn view-details">View Details</button>
                        <button class="btn buy-button">Buy</button>
                    </div>
                </div>

            </section>
        </div>
    </div>

</body>

</html>
