<?php
session_start();
require_once '../config/database.php';

if (!isset($_GET['id'])) {
    header("Location: shop.php");
    exit();
}

$product_id = $_GET['id'];

// Get product details
try {
    $stmt = $pdo->prepare("SELECT * FROM inventory WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if (!$product) {
        header("Location: shop.php");
        exit();
    }
} catch(PDOException $e) {
    header("Location: shop.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']); ?> - HOT4HAPART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/homepage.css">
    <style>
        .product-detail-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1rem;
        }
        .product-detail-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 2rem;
            display: flex;
            gap: 2rem;
        }
        .product-image {
            width: 300px;
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }
        .product-info {
            flex: 1;
        }
        .product-name {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        .product-description {
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.6;
        }
        .product-price {
            font-size: 1.5rem;
            color: #ff4500;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .stock-info {
            color: #666;
            margin-bottom: 1.5rem;
        }
        .btn-container {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        .barcode-container {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .barcode-icon {
            font-size: 1.5rem;
            color: #333;
        }
        .barcode-number {
            font-family: monospace;
            font-size: 1.2rem;
            color: #333;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
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
                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">Shop</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id']) || isset($_SESSION['guest'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="product-detail-container">
        <div class="product-detail-card">
            <img src="<?= htmlspecialchars($product['image_url']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="product-image">
            <div class="product-info">
                <h2 class="product-name"><?= htmlspecialchars($product['name']); ?></h2>
                <?php if (!empty($product['barcode'])): ?>
                <div class="barcode-container">
                    <i class="fas fa-barcode barcode-icon"></i>
                    <span class="barcode-number"><?= htmlspecialchars($product['barcode']); ?></span>
                </div>
                <?php endif; ?>
                <p class="product-description"><?= htmlspecialchars($product['description']); ?></p>
                <p class="product-price">₱<?= number_format($product['price'], 2); ?></p>
                <p class="stock-info">In Stock: <?= htmlspecialchars($product['quantity']); ?> units</p>
                
                <div class="btn-container">
                    <form action="checkout.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                        <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']); ?>">
                        <input type="hidden" name="price" value="<?= $product['price']; ?>">
                        <button type="submit" class="btn btn-primary buy-button">Buy Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>