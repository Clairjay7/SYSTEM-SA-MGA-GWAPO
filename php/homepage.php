<!-- filepath: f:\xammp\htdocs\SYSTEM-SA-MGA-GWAPO\php\homepage.php -->
<?php
session_start();
require_once '../config/database.php';

// Get all products from database
try {
    $stmt = $pdo->query("SELECT * FROM inventory WHERE quantity > 0 ORDER BY created_at DESC");
    $products = $stmt->fetchAll();
} catch(PDOException $e) {
    $error = "Error fetching products: " . $e->getMessage();
}

// Get success message if set
$success = $_SESSION['success'] ?? '';
unset($_SESSION['success']);

// Check if user is logged in or is a guest
$logged_in = isset($_SESSION['user_id']);
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$is_guest = isset($_SESSION['guest']);

// Check if user has started shopping
$started_shopping = isset($_SESSION['started_shopping']);

// Handle start shopping action
if (isset($_POST['start_shopping'])) {
    $_SESSION['started_shopping'] = true;
    header("Location: homepage.php");
    exit();
}

// If not logged in and not a guest, redirect to login
if (!$logged_in && !$is_guest) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOT4HAPART - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/homepage.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="homepage.php">HOT4HAPART</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if ($is_admin): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">Admin Dashboard</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if ($logged_in || $is_guest): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Login</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php if ($is_guest && !$started_shopping): ?>
    <div class="welcome-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <img src="../grrr.png" alt="HOT4HAPART Logo" class="mb-4" style="max-width: 200px;">
                    <h1 class="welcome-title">Welcome to HOT4HAPART</h1>
                    <p class="welcome-text">Discover our exclusive collection of die-cast cars and collectibles. Start your journey with us today!</p>
                    <div class="welcome-buttons">
                        <form method="POST" class="d-inline">
                            <button type="submit" name="start_shopping" class="btn btn-primary btn-lg me-3">Start Shopping</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <!-- Promotional Banner Section -->
    <section class="banner-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 banner-content">
                    <h1 class="banner-title">MORE THRILLING ACTION</h1>
                    <p class="banner-text">Discover our latest collection of premium die-cast cars and exclusive collectibles. Find your next treasure today!</p>
                    <a href="shop.php" class="banner-button text-decoration-none">SHOP NOW</a>
                </div>
                <div class="col-lg-6">
                    <img src="../grrr.png" alt="HOT4HAPART Logo" class="banner-image">
                </div>
            </div>
        </div>
    </section>

    <!-- Product Showcase Section -->
    <section class="product-showcase">
        <div class="container">
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <div class="row mb-4">
                <div class="col">
                    <h2 class="text-center mb-5">Featured Collection</h2>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="featured-card">
                        <img src="https://images.mattel.net/image/upload/w_540,f_auto,c_scale/shop-contentstack/blt35c86167a13a3c8a/67e1ad53362ee3157a55c888/HW_LP_Minecraft_Movie_CardSplit_1694x1505.jpg" alt="Pixelated Adventures" class="card-img-top">
                        <div class="card-body">
                            <h3>Pixelated Adventures</h3>
                            <p>Thrill action fans with RacerVerse toys inspired by the new Minecraft movie, in theaters this April.</p>
                            <a href="shop.php?category=minecraft" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="featured-card">
                        <img src="https://images.mattel.net/image/upload/w_540,f_auto,c_scale/shop-contentstack/blt7ff6e7ccfbc372d3/678157779ca4c0e88f8142e3/HW_LP_MT-Big-Foot_50th_CardSplit_1694x1505.jpg" alt="Bigfoot Turns 50" class="card-img-top">
                        <div class="card-body">
                            <h3>Bigfoot Turns 50</h3>
                            <p>Fans can celebrate the world's most famous Monster Truck with our epic anniversary toys.</p>
                            <a href="shop.php?category=monster-trucks" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="featured-card">
                        <img src="https://images.mattel.net/image/upload/w_540,f_auto,c_scale/shop-contentstack/blt794f21430ea265e3/6810f364733c4a31b8329fe5/MBKS_HomePage_Card_1694x1505-Custom_(1).jpg" alt="Mattel Brick Shop" class="card-img-top">
                        <div class="card-body">
                            <h3>Mattel Brick Shop</h3>
                            <p>Featuring metal parts and customization, these iconic cars are yours to build.</p>
                            <a href="shop.php?category=custom" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="shop.php" class="btn btn-lg btn-primary">View All Products</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Challenge Accepted Section -->
    <section class="challenge-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="challenge-content">
                        <img src="../grrr.png" alt="Hot Wheels Logo" class="challenge-logo mb-4">
                        <h2 class="challenge-title">CHALLENGE ACCEPTED™</h2>
                        <h3 class="challenge-subtitle">TRY. FAIL. REPEAT. GROW.</h3>
                        <p class="challenge-text">When kids play with Hot Wheels, every attempt teaches them to take on challenges, develop problem-solving skills, and cultivate a growth mindset.</p>
                        <a href="challenge.php" class="challenge-button">Learn More</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="challenge-image">
                        <img src="https://sdmntpreastus2.oaiusercontent.com/files/00000000-675c-61f6-99c0-289151dc2877/raw?se=2025-05-26T17%3A45%3A17Z&sp=r&sv=2024-08-04&sr=b&scid=2f7b03e6-33d7-55f5-9502-cf4dd6fd38d2&skoid=31bc9c1a-c7e0-460a-8671-bf4a3c419305&sktid=a48cca56-e6da-484e-a814-9c849652bcb3&skt=2025-05-26T01%3A14%3A09Z&ske=2025-05-27T01%3A14%3A09Z&sks=b&skv=2024-08-04&sig=BLtGwNiMA%2BwWsph6o6IEDQNsNH7%2B4GDuA6x3U6XufBI%3D" alt="Hot Wheels Track" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>