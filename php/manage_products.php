<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Initialize variables
$products = [];
$error = null;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

// Get products from database with search and category filter
try {
    $where_conditions = ["deleted_at IS NULL"];
    $params = [];

    if (!empty($search)) {
        $where_conditions[] = "(name LIKE ? OR barcode LIKE ? OR description LIKE ?)";
        $searchTerm = "%{$search}%";
        $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm]);
    }

    if (!empty($category_filter) && $category_filter !== 'All Categories') {
        $where_conditions[] = "category = ?";
        $params[] = $category_filter;
    }

    $where_clause = implode(" AND ", $where_conditions);
    $sql = "SELECT * FROM inventory WHERE {$where_clause} ORDER BY created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $error = "Error fetching products: " . $e->getMessage();
}

// Get success/error messages
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? $error ?? '';
unset($_SESSION['success'], $_SESSION['error']);

// Define categories
$categories = ['All Categories', 'Regular', 'Premium', 'Limited Edition'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inventory - HOT4HAPART</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .search-container {
            margin-bottom: 20px;
        }
        .search-input {
            max-width: 300px;
        }
        .category-filter {
            width: 200px;
            margin-right: 10px;
        }
        .category-badge {
            font-size: 0.85em;
            padding: 0.35em 0.65em;
        }
        .category-Regular {
            background-color: #28a745;
        }
        .category-Premium {
            background-color: #007bff;
        }
        .category-Limited {
            background-color: #dc3545;
        }
    </style>
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
                    <li class="nav-item">
                        <a class="nav-link" href="sales.php">Sales Records</a>
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
                <h2>Manage Inventory</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="add_product.php" class="btn btn-primary">Add New Item</a>
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

        <!-- Search and Filter Form -->
        <div class="search-container">
            <form action="" method="GET" class="row g-3">
                <div class="col-md-4">
                    <select name="category" class="form-select category-filter" onchange="this.form.submit()">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat; ?>" <?php echo $category_filter === $cat ? 'selected' : ''; ?>>
                                <?php echo $cat; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by name, barcode, or description" value="<?php echo htmlspecialchars($search); ?>">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </div>
                <?php if (!empty($search) || (!empty($category_filter) && $category_filter !== 'All Categories')): ?>
                <div class="col-md-2">
                    <a href="manage_products.php" class="btn btn-outline-secondary">Clear Filters</a>
                </div>
                <?php endif; ?>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Barcode</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Image</th>
                        <th>Created At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="10" class="text-center">No items found.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['id'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($product['name'] ?? ''); ?></td>
                            <td>
                                <span class="badge category-badge category-<?php echo htmlspecialchars($product['category'] ?? 'Regular'); ?>">
                                    <?php echo htmlspecialchars($product['category'] ?? 'Regular'); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($product['barcode'] ?? 'No barcode'); ?></td>
                            <td><?php echo htmlspecialchars(substr($product['description'] ?? '', 0, 50)) . '...'; ?></td>
                            <td>₱<?php echo number_format((float)($product['price'] ?? 0), 2); ?></td>
                            <td><?php echo htmlspecialchars((string)($product['quantity'] ?? $product['stock_quantity'] ?? 0)); ?></td>
                            <td>
                                <?php if (!empty($product['image_url'])): ?>
                                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" style="max-width: 50px;">
                                <?php else: ?>
                                    No image
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($product['created_at']); ?></td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <!-- Category Buttons -->
                                    <div class="dropdown d-inline-block me-1">
                                        <button class="btn btn-sm btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Category
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <form action="update_category.php" method="POST" class="d-inline">
                                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                    <input type="hidden" name="category" value="Regular">
                                                    <button type="submit" class="dropdown-item">Regular</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="update_category.php" method="POST" class="d-inline">
                                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                    <input type="hidden" name="category" value="Premium">
                                                    <button type="submit" class="dropdown-item">Premium</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="update_category.php" method="POST" class="d-inline">
                                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                    <input type="hidden" name="category" value="Limited Edition">
                                                    <button type="submit" class="dropdown-item">Limited Edition</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- Edit Button -->
                                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-warning me-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                    </a>
                                    <!-- Delete Button -->
                                    <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                    </a>
                                </div>
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