<?php
session_start();

// Check if user is logged in or a guest
if (!isset($_SESSION['user_id']) && !isset($_SESSION['guest'])) {
    header("Location: index.php");
    exit();
}

// If guest session is set, don't check for user id
if (isset($_SESSION['guest'])) {
    $username = "Guest"; // Set a default username for the guest user
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
            <?php if (isset($_SESSION['user_id']) || isset($_SESSION['guest'])): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
            <li><a href="getHelp.php" class="get-help-btn">Get Help</a></li>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
                <li><a href="manageUsers.php">Manage Users</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="dashboard-container">
        <section class="dashboard-buttons">
        </section>

        <!-- Main Content -->
        <div class="main-content">
            <header class="hero-section">
                <h2>Welcome, <?php echo isset($username) ? $username : 'User'; ?>!</h2>
                <p>Discover, Collect, and Race with the Best Cars</p>
            </header>

                <!-- Products Section -->
                <section class="product-grid">
                    <div class="product-card">
                        <img src="https://i.ebayimg.com/images/g/VgcAAeSwunZnoqL~/s-l960.webp" alt="Hot Wheels Car">
                        <h3>Hot Wheels 1997 FE Lamborghini Countach Yellow 25th Ann.</h3>
                        <p class="product-price">$100.75</p>
                        <div class="button-container">
                            <button class="btn view-details">View Details</button>
                            <button class="btn buy-button">Buy</button>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://i.ebayimg.com/images/g/iYcAAeSwCPtno9af/s-l960.webp" alt="Hot Wheels Car">
                        <h3>Hot Wheels 1999 Ferrari F355 Berlinetta Red 5SP</h3>
                        <p class="product-price">$1000.75</p>
                        <div class="button-container">
                            <button class="btn view-details">View Details</button>
                            <button class="btn buy-button">Buy</button>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://i.ebayimg.com/images/g/6DoAAeSwQ71npOES/s-l960.webp" alt="Hot Wheels Car">
                        <h3>Hot Wheels 2000 Lamborghini Diablo Blue 5DOT Virtual Cars</h3>
                        <p class="product-price">$555.75</p>
                        <div class="button-container">
                            <button class="btn view-details">View Details</button>
                            <button class="btn buy-button">Buy</button>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://i.ebayimg.com/images/g/9w8AAeSwIIZnyFvK/s-l960.webp" alt="Hot Wheels Car">
                        <h3>2023 Hot Wheels DC Batmobile 103/250 1:64 Diecast Car White Batman Series 3/5</h3>
                        <p class="product-price">$111.75</p>
                        <div class="button-container">
                            <button class="btn view-details">View Details</button>
                            <button class="btn buy-button">Buy</button>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://i.ebayimg.com/images/g/AcIAAeSwg8lnyG9o/s-l960.webp" alt="Hot Wheels Car">
                        <h3>2025 Hot Wheels Premium Car Culture 2 Pack Lamborghini Countach & Lancia Stratos</h3>
                        <p class="product-price">$15.75</p>
                        <div class="button-container">
                            <button class="btn view-details">View Details</button>
                            <button class="btn buy-button">Buy</button>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://i.ebayimg.com/images/g/LBwAAeSwUzNnyFr9/s-l500.webp" alt="Hot Wheels Car">
                        <h3>Hot Wheels City Playset Downtown Aquarium Bash Set Track Connect FMY99</h3>
                        <p class="product-price">$15.75</p>
                        <div class="button-container">
                            <button class="btn view-details">View Details</button>
                            <button class="btn buy-button">Buy</button>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://i.ebayimg.com/images/g/mzAAAOSw-rBnyG2f/s-l1600.webp" alt="Hot Wheels Car">
                        <h3>New Monster Jam SPARKLE SMASH vs SPARKLE SMASH Rainbow Unicorn Truck 2 PACK</h3>
                        <p class="product-price">$15.75</p>
                        <div class="button-container">
                            <button class="btn view-details">View Details</button>
                            <button class="btn buy-button">Buy</button>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://i.ebayimg.com/images/g/UoYAAeSw~5lnyG4T/s-l960.webp" alt="Hot Wheels Car">
                        <h3>2025 Hot Wheels Premium Car Culture Spoon Honda Civic Type R 2 Pack .</h3>
                        <p class="product-price">$15.75</p>
                        <div class="button-container">
                            <button class="btn view-details">View Details</button>
                            <button class="btn buy-button">Buy</button>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://i.ebayimg.com/images/g/ScoAAeSwPfRnyHBi/s-l960.webp" alt="Hot Wheels Car">
                        <h3>HOT WHEELS CAD BANE Star Wars Character Cars - Book of Bobba Fett - NEW On-Card</h3>
                        <p class="product-price">$15.75</p>
                        <div class="button-container">
                            <button class="btn view-details">View Details</button>
                            <button class="btn buy-button">Buy</button>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://i.ebayimg.com/images/g/mo0AAeSwU3Znx~NH/s-l960.webp" alt="Hot Wheels Car">
                        <h3>HOT WHEELS 2024 ULTRA HOTS SERIES 3 #1 1970 FORD ESCORT RS1600</h3>
                        <p class="product-price">$15.75</p>
                        <div class="button-container">
                            <button class="btn view-details">View Details</button>
                            <button class="btn buy-button">Buy</button>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://i.ebayimg.com/images/g/f64AAeSwLtNnx-dA/s-l960.webp" alt="Hot Wheels Car">
                        <h3>Hot Wheels 2025 HW Race Day Porsche 904 Carrera GTS Yellow #100 100/250</h3>
                        <p class="product-price">$15.75</p>
                        <div class="button-container">
                            <button class="btn view-details">View Details</button>
                            <button class="btn buy-button">Buy</button>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://i.ebayimg.com/images/g/5LoAAOSwVFVnAJbi/s-l1600.webp" alt="Hot Wheels Car">
                        <h3>1983 DETOMASO PANTERA BLUE 1:18 HOT WHEELS 2000 VERY RARE</h3>
                        <p class="product-price">$15.75</p>
                        <div class="button-container">
                            <button class="btn view-details">View Details</button>
                            <button class="btn buy-button">Buy</button>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://i.ebayimg.com/images/g/KpYAAOSw~YBnjW81/s-l1600.webp" alt="Hot Wheels Car">
                        <h3>2022 Hot Wheels DG Exclus #98 HW J-Imports 2/10 CUSTOM 01 ACURA INTEGRA GSR Blue</h3>
                        <p class="product-price">$15.75</p>
                        <div class="button-container">
                            <button class="btn view-details">View Details</button>
                            <button class="btn buy-button">Buy</button>
                        </div>
                    </div>
                    <div class="product-card">
                        <img src="https://i.ebayimg.com/images/g/gd0AAOSw8fZnxWyJ/s-l960.webp" alt="Hot Wheels Car">
                        <h3>HOT WHEELS SUBARU WRX STI 2025 JDM 100% CUSTOM GARAGE</h3>
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
