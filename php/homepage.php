<!-- filepath: f:\xammp\htdocs\SYSTEM-SA-MGA-GWAPO\php\homepage.php -->
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">Hot Wheels</div>
        <ul class="nav-links">
            <li><a href="homepage.php">Home</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to Hot Wheels</h1>
            <p>Discover the latest collections and exclusive offers.</p>
            <a href="shop.php" class="btn">Shop Now</a>
        </div>
    </section>

    <!-- Featured Section -->
    <section class="featured-section">
    <h2>Featured Collections</h2>
    <div class="featured-carousel">
        <div class="featured-card">
            <img src="https://images.mattel.net/images/w_540,c_scale,f_auto/shop-us-prod/files/ac6e23da0a29fe2f4401d89e662510b75ad5a5a3/hot-wheels-racerverse-ender-dragons-last-lap-track-set-jfp34-hover.jpg" alt="Minecraft Adventures">
            <h3>Pixelated Adventures</h3>
            <p>Thrill action fans with RacerVerse toys inspired by the new Minecraft movie, in theaters this April.</p>
            <a href="shop.php" class="btn-link">Shop Now</a>
        </div>
        <div class="featured-card">
            <img src="https://images.mattel.net/image/upload/w_540,f_auto,c_scale/shop-contentstack/blt7ff6e7ccfbc372d3/678157779ca4c0e88f8142e3/HW_LP_MT-Big-Foot_50th_CardSplit_1694x1505.jpg" alt="Bigfoot Turns 50">
            <h3>Bigfoot Turns 50</h3>
            <p>Fans can celebrate the world’s most famous Monster Truck with our epic anniversary toys.</p>
            <a href="shop.php" class="btn-link">Shop Now</a>
        </div>
        <div class="featured-card">
            <img src="https://images.mattel.net/image/upload/w_540,f_auto,c_scale/shop-contentstack/blt794f21430ea265e3/6810f364733c4a31b8329fe5/MBKS_HomePage_Card_1694x1505-Custom_(1).jpg" alt="Mattel Brick Shop">
            <h3>Mattel Brick Shop</h3>
            <p>Featuring metal parts and customization, these iconic cars are yours to build.</p>
            <a href="shop.php" class="btn-link">Shop Now</a>
        </div>
        <div class="featured-card">
            <img src="https://images.mattel.net/image/upload/w_646,f_auto,c_scale/shop-us-prod/files/i66xirdyioz117d7y95h_0ba02582-cae4-4aea-81f5-55823bd2eaeb.jpg" alt="Hot Wheels Monster Trucks">
            <h3>Monster Truck Madness</h3>
            <p>Hot Wheels Racerverse, Set Of 4 Die-Cast Hot Wheels Cars With Pop Culture Characters As Drivers.</p>
            <a href="shop.php" class="btn-link">Shop Now</a>
        </div>
        <div class="featured-card">
            <img src="https://images.mattel.net/image/upload/w_646,f_auto,q_60,c_pad/shop-us-prod/products/yixrqlajfvzdrxjwkyoz_ed38ac64-c49a-4587-9fae-83d5645d1489.png" alt="Hot Wheels Track Builder">
            <h3>Track Builder Unlimited</h3>
            <p>Hot Wheels Racerverse, Set Of 4 Die-Cast Hot Wheels Cars With Jurassic World Characters As Drivers.</p>
            <a href="shop.php" class="btn-link">Shop Now</a>
        </div>
        <div class="featured-card">
            <img src="https://images.mattel.net/image/upload/w_540,f_auto,c_scale/shop-contentstack/blt7ff6e7ccfbc372d3/678157779ca4c0e88f8142e3/HW_LP_MT-Big-Foot_50th_CardSplit_1694x1505.jpg" alt="Hot Wheels Legends">
            <h3>Hot Wheels Legends</h3>
            <p>Discover the legendary cars that have defined generations of Hot Wheels fans.</p>
            <a href="shop.php" class="btn-link">Shop Now</a>
        </div>
    </div>
</section>
    
    

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Hot Wheels. All rights reserved.</p>
        <div class="social-links">
            <a href="#">Facebook</a>
            <a href="#">Twitter</a>
            <a href="#">Instagram</a>
        </div>
    </footer>
</body>
</html>