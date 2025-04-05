<?php
session_start();

// Check if user is logged in or a guest
if (!isset($_SESSION['user_id']) && !isset($_SESSION['guest'])) {
    header("Location: ../php/index.php");
    exit();
}

// If guest session is set, don't check for user id
if (isset($_SESSION['guest'])) {
    $username = "Guest"; // Set a default username for the guest user
}
<<<<<<< HEAD

// Fetch advertising content from the API (if needed)
function get_ads_from_api() {
    $url = "http://localhost/SYSTEM-SA-MGA-GWAPO/api/ads.php"; // Adjust API URL as needed
    $response = @file_get_contents($url);  // Use @ to suppress warnings temporarily

    if ($response === FALSE) {
        // Log or handle the error if the API call fails
        error_log("Error fetching ads from API: $url");
        return []; // Return an empty array if API call fails
    }

    $data = json_decode($response, true); // Decode JSON response to an array

    // Check if the data is valid
    if (is_array($data)) {
        return $data;
    } else {
        error_log("Invalid data received from API: " . print_r($data, true));
        return []; // Return an empty array if data is invalid
    }
}

$ads = get_ads_from_api(); // Fetch dynamic ads
=======
>>>>>>> c739b7baacb2d2ed47c87c308876a7249c13214a
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Hot Wheels Store - Advertising</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="../js/script.js" defer></script>
    <link rel="stylesheet" href="../css/ads.css"> <!-- Link to external CSS file for ads -->
=======
    <title>Hot Wheels Store</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="../js/script.js" defer></script>
>>>>>>> c739b7baacb2d2ed47c87c308876a7249c13214a
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <h1>Hapart 4 Speed</h1>
        <ul>
            <li><a href="#">Home</a></li>
<<<<<<< HEAD
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="../php/shop.php">Shop</a></li>
=======
            <li><a href="#">Shop</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
>>>>>>> c739b7baacb2d2ed47c87c308876a7249c13214a
            <?php if (isset($_SESSION['user_id']) || isset($_SESSION['guest'])): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="dashboard-container">
        <section class="dashboard-buttons">
<<<<<<< HEAD
            <!-- Back to Admin Dashboard Button -->
            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
                <a href="admin_dashboard.php" class="back-to-dashboard-btn">Back to Admin Dashboard</a>
            <?php endif; ?>
        </section>
=======
    <!-- Back to Admin Dashboard Button -->
    <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
        <a href="admin_dashboard.php" class="back-to-dashboard-btn">Back to Admin Dashboard</a>
    <?php endif; ?>
</section>


>>>>>>> c739b7baacb2d2ed47c87c308876a7249c13214a

        <!-- Main Content -->
        <div class="main-content">
            <header class="hero-section">
                <h2>Welcome, <?php echo isset($username) ? $username : 'User'; ?>!</h2>
<<<<<<< HEAD
                <p>Check Out Our Latest Ads and Offers</p>
            </header>

            <!-- Advertising Section -->
            <section class="advertising-section">
                <?php if (!empty($ads) && is_array($ads)): ?>
                    <div class="ad-grid">
                        <?php foreach ($ads as $ad): ?>
                            <div class="ad-card <?php echo isset($ad['animation_type']) ? $ad['animation_type'] : ''; ?>" style="border: none; padding: 20px;">
                                <a href="<?= isset($ad['link']) ? $ad['link'] : '#'; ?>" target="_blank">
                                    <img src="<?= isset($ad['image_url']) ? $ad['image_url'] : '#'; ?>" alt="<?= isset($ad['title']) ? htmlspecialchars($ad['title']) : 'Ad'; ?>" style="border: none;">
                                </a>
                                <h3><?= isset($ad['title']) ? htmlspecialchars($ad['title']) : 'No Title'; ?></h3>
                                <p class="ad-description"><?= isset($ad['description']) ? htmlspecialchars($ad['description']) : 'No Description'; ?></p>
                                <a href="<?= isset($ad['link']) ? $ad['link'] : '#'; ?>" class="ad-link">Learn More</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No ads available at the moment.</p>
                <?php endif; ?>
=======
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
                        <img src="https://i.ebayimg.com/images/g/lT0AAOSw5eNnw~qd/s-l1600.webp" alt="Hot Wheels Car">
                        <h3>HOT WHEELS SUBARU WRX STI 2025 JDM 100% CUSTOM GARAGE</h3>
                        <p class="product-price">$15.75</p>
                        <div class="button-container">
                            <button class="btn view-details">View Details</button>
                            <button class="btn buy-button">Buy</button>
                    </div>
                </div>
>>>>>>> c739b7baacb2d2ed47c87c308876a7249c13214a
            </section>
        </div>
    </div>

<<<<<<< HEAD
    <script>
        // Optional: Additional JavaScript for ad interaction (e.g., hover effects)
    </script>

</body>
</html>
=======
</body>
</html>
>>>>>>> c739b7baacb2d2ed47c87c308876a7249c13214a
