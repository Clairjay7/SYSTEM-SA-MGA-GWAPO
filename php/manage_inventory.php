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

// Fetch all inventory items from the database
try {
    $stmt = $pdo->prepare("SELECT * FROM inventory");
    $stmt->execute();
    $inventory = $stmt->fetchAll();  // Fetch all inventory records
} catch (PDOException $e) {
    die("Error fetching inventory: " . $e->getMessage());
}

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
        <a href="../php/admin_dashboard.php">
            <button class="back-button">Back to Admin Dashboard</button>
        </a>
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
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($inventory)): ?>
                    <?php foreach ($inventory as $item): ?>
                        <tr>
                            <td><?= $item['id']; ?></td>
                            <td><?= htmlspecialchars($item['product_name']); ?></td>
                            <td><?= htmlspecialchars($item['price']); ?></td>
                            <td><?= htmlspecialchars($item['quantity']); ?></td>
                            <td>
                                <a href="../php/editProduct.php?id=<?= $item['id']; ?>">Edit</a> | 
                                <a href="/php/manage_inventory.php?delete_id=<?= $item['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">No products found</td>
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
