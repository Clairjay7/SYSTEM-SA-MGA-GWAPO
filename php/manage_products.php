<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Initialize products array
$products = [];
$error = null;

// Get all products from database
try {
    $stmt = $pdo->query("SELECT * FROM inventory ORDER BY created_at DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error = "Error fetching products: " . $e->getMessage();
}

// Get success/error messages
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? $error ?? '';
unset($_SESSION['success'], $_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Galorpot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="homepage.php">View Site</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_users.php">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="manage_products.php">Manage Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_orders.php">Manage Orders</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2>Manage Products</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="add_product.php" class="btn btn-primary">Add New Product</a>
            </div>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Image</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="8" class="text-center">No products found.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['id']); ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars(substr($product['description'], 0, 50)) . '...'; ?></td>
                            <td>₱<?php echo number_format($product['price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                            <td>
                                <?php if (!empty($product['image_url'])): ?>
                                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="max-width: 50px;">
                                <?php else: ?>
                                    No image
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($product['created_at']); ?></td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 