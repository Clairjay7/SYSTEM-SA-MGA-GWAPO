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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hot Wheels Store - Advertising</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="../js/script.js" defer></script>
    <link rel="stylesheet" href="../css/ads.css"> <!-- Link to external CSS file for ads -->
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <h1>Hapart 4 Speed</h1>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="../php/shop.php">Shop</a></li>
            <?php if (isset($_SESSION['user_id']) || isset($_SESSION['guest'])): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="dashboard-container">
        <section class="dashboard-buttons">
            <!-- Back to Admin Dashboard Button -->
            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
                <a href="admin_dashboard.php" class="back-to-dashboard-btn">Back to Admin Dashboard</a>
            <?php endif; ?>
        </section>

        <!-- Main Content -->
        <div class="main-content">
            <header class="hero-section">
                <h2>Welcome, <?php echo isset($username) ? $username : 'User'; ?>!</h2>
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
            </section>
        </div>
    </div>

    <script>
        // Optional: Additional JavaScript for ad interaction (e.g., hover effects)
    </script>

</body>
</html>
