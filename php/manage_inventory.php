<!-- filepath: f:\xammp\htdocs\SYSTEM-SA-MGA-GWAPO\php\manage_inventory.php -->
<?php
session_start();
require_once '../php/connect.php'; // Ensure your connect.php file is included for database connection

// Check if the user is logged in as Admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../php/login.php"); // Redirect to login page if not an Admin
    exit();
}

// DELETE FUNCTION (Direct in manage_inventory.php)
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete product by ID
    try {
        $stmt = $pdo->prepare("DELETE FROM inventory WHERE id = :id");
        $stmt->bindParam(':id', $delete_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect after deletion
        header("Location: ../php/manage_inventory.php");
        exit();
    } catch (PDOException $e) {
        die("Error deleting product: " . $e->getMessage());
    }
}

// Fetch products including quantity
$query = "SELECT id, product_name, price, image_url, quantity FROM inventory";
$stmt = $pdo->query($query);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inventory</title>
    <link rel="stylesheet" href="../css/inventory.css">
</head>
<body>
    <header>
        <!-- Back button aligned to the left -->
        <a href="../php/admin_dashboard.php" class="back-button">Back to Admin Dashboard</a>
        
        <div class="manage-title">
            <h1>Manage Inventory</h1>
        </div>
    </header>
    
    <!-- Center the Manage Inventory title above the Inventory List -->
    <div style="text-align: center; margin-top: 40px;">
        <h2>Inventory List</h2>
        <table border="1" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Quantity</th>  <!-- Added Quantity Column -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['id']; ?></td>
                            <td><?= htmlspecialchars($product['product_name']); ?></td>
                            <td><?= htmlspecialchars($product['price']); ?></td>
                            <td><img src="<?= htmlspecialchars($product['image_url']); ?>" alt="<?= htmlspecialchars($product['product_name']); ?>" width="100"></td>
                            <td><?= htmlspecialchars($product['quantity']); ?></td>  <!-- Display Quantity -->
                            <td>
                                <a href="../php/editProduct.php?id=<?= $product['id']; ?>">Edit</a> | 
                                <a href="/php/manage_inventory.php?delete_id=<?= $product['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No products found</td>  <!-- Adjust colspan -->
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <br><br>
        <a href="../php/add_inventory.php">
            <button>Add New Product</button>
        </a>
    </div>
</body>
</html>