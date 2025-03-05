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
    <nav class="navbar">
        <h1>Hapart for Speed</h1>
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Shop</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href='logout.php'>Logout</a></li>
            <li><a href="getHelp.php" class="get-help-btn">Get Help</a></li>
        </ul>
    </nav>
    
    <div class="dashboard-container">
        <section class="dashboard-buttons">
            <!-- Manage Inventory Button with Link -->
            <button class="dashboard-btn" onclick="location.href='manageInventory.php'">Manage Inventory</button>
            <button class="dashboard-btn">Orders</button>
            <button class="dashboard-btn">Users</button>
            <button class="dashboard-btn">Settings</button>
        </section>
    
        <div class="main-content">
            <header class="hero-section">
                <h2>Welcome to the Ultimate Hot Wheels Collection</h2>
                <h2>Discover, Collect, and Race with the Best Cars</h2>
            </header>

            <!-- PRODUCTS SECTION -->
            <section class="product-grid">
                <div class="product-card">
                    <img src="hotwheels_super_speedster.jpg" alt="Hot Wheels Super Speedster" style="width:100%;">
                    <h3>Hot Wheels Car</h3>
                    <button class="btn">View Details</button>
                    <button class="btn buy-btn">Buy</button>
                </div>
                <div class="product-card">
                    <img src="car2.jpg" alt="Hot Wheels Car">
                    <h3>Classic Racer</h3>
                    <button class="btn">View Details</button>
                    <button class="btn buy-btn">Buy</button>
                </div>
                <div class="product-card">
                    <img src="car3.jpg" alt="Hot Wheels Car">
                    <h3>Offroad Monster</h3>
                    <button class="btn">View Details</button>
                    <button class="btn buy-btn">Buy</button>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
