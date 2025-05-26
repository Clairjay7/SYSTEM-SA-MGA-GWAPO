<!-- filepath: f:\xammp\htdocs\SYSTEM-SA-MGA-GWAPO\php\manage_inventory.php -->
<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Handle success/error messages
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);

// Get all products from database
try {
    $query = "SELECT id, name, price, image_url, quantity FROM inventory";
    $stmt = $pdo->query($query);
    $products = $stmt->fetchAll();
} catch(PDOException $e) {
    $error = "Error fetching products: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inventory - Galorpot</title>
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
                        <a class="nav-link active" href="manage_inventory.php">Manage Inventory</a>
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

        <div class="row mb-4">
            <div class="col-md-6">
                <h2>Inventory Management</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="add_product.php" class="btn btn-primary">Add New Product</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['id']); ?></td>
                        <td><?= htmlspecialchars($product['name']); ?></td>
                        <td>₱<?= number_format($product['price'], 2); ?></td>
                        <td><img src="<?= htmlspecialchars($product['image_url']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" width="100"></td>
                        <td><?= htmlspecialchars($product['quantity']); ?></td>
                        <td>
                            <a href="edit_product.php?id=<?= $product['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="delete_product.php?id=<?= $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>