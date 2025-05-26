<?php
session_start();
require_once '../config/database.php';

// Get sort and search parameters
$sort = $_GET['sort'] ?? 'newest';
$search = $_GET['search'] ?? '';

// Build the SQL query based on sort and search
$sql = "SELECT * FROM inventory WHERE quantity > 0";

// Add search condition if search term is provided
if (!empty($search)) {
    $sql .= " AND (name LIKE :search OR description LIKE :search)";
}

// Add sorting
$sql .= " ORDER BY ";
switch ($sort) {
    case 'price-low':
        $sql .= "price ASC";
        break;
    case 'price-high':
        $sql .= "price DESC";
        break;
    case 'name':
        $sql .= "name ASC";
        break;
    default: // newest
        $sql .= "created_at DESC";
}

// Get all products from database
try {
    $stmt = $pdo->prepare($sql);
    if (!empty($search)) {
        $searchTerm = "%{$search}%";
        $stmt->bindParam(':search', $searchTerm);
    }
    $stmt->execute();
    $products = $stmt->fetchAll();
} catch(PDOException $e) {
    $error = "Error fetching products: " . $e->getMessage();
}

// Check if user is logged in or is a guest
$logged_in = isset($_SESSION['user_id']);
$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$is_guest = isset($_SESSION['guest']);

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
    <title>Shop - HOT4HAPART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/homepage.css">
    <style>
        .shop-header {
            background: linear-gradient(135deg, #e31837 0%, #c41230 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 40px;
        }
        
        .shop-header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .shop-content {
            flex: 1;
        }
        
        .shop-logo {
            max-width: 200px;
            margin-left: 40px;
        }
        
        .shop-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        
        .shop-description {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .filter-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .product-grid {
            padding: 40px 0;
        }
        
        .no-results {
            text-align: center;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 10px;
            margin: 20px 0;
        }
    </style>
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
                    <li class="nav-item">
                        <a class="nav-link" href="homepage.php">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if ($is_admin): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">Admin Dashboard</a>
                    </li>
                    <?php endif; ?>
                    <?php if ($logged_in): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Shop Header -->
    <header class="shop-header">
        <div class="container">
            <div class="shop-content">
                <h1 class="shop-title">HOT4HAPART SHOP</h1>
                <p class="shop-description">Browse our extensive collection of die-cast cars and exclusive collectibles</p>
            </div>
            <img src="../grrr.png" alt="HOT4HAPART Logo" class="shop-logo">
        </div>
    </header>

    <!-- Main Shop Content -->
    <div class="container">
        <!-- Filter Section -->
        <div class="filter-section">
            <form id="filterForm" class="row g-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="sort" class="form-label">Sort By</label>
                        <select class="form-select" id="sort" name="sort">
                            <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Newest First</option>
                            <option value="price-low" <?php echo $sort === 'price-low' ? 'selected' : ''; ?>>Price: Low to High</option>
                            <option value="price-high" <?php echo $sort === 'price-high' ? 'selected' : ''; ?>>Price: High to Low</option>
                            <option value="name" <?php echo $sort === 'name' ? 'selected' : ''; ?>>Name: A to Z</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                </div>
            </form>
        </div>

        <!-- Product Grid -->
        <section class="product-grid">
            <?php if (empty($products)): ?>
                <div class="no-results">
                    <h3>No products found</h3>
                    <p>Try adjusting your search or filter criteria</p>
                </div>
            <?php else: ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($products as $product): ?>
                <div class="col">
                    <div class="card product-card">
                        <?php if ($product['image_url']): ?>
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="card-img-top product-image" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="product-price">₱<?php echo number_format($product['price'], 2); ?></p>
                            <p class="product-stock">Stock: <?php echo htmlspecialchars($product['quantity']); ?> units</p>
                            <div class="d-grid gap-2">
                                <a href="product_details.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-primary">View Details</a>
                                <form action="checkout.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">
                                    <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                    <button type="submit" class="btn buy-button w-100">Buy Now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-submit form when sort or search changes
        document.getElementById('sort').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        // Add debounce for search to avoid too many requests
        let searchTimeout;
        document.getElementById('search').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 500); // Wait 500ms after user stops typing
        });
    </script>
</body>
</html>