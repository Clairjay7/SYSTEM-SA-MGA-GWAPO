<?php
session_start();
require_once '../php/connect.php';

// Redirect to login if not logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../php/login.php");
    exit();
}

// Check if product ID is provided
if (!isset($_GET['id'])) {
    header("Location: ../php/manage_inventory.php");
    exit();
}

$id = $_GET['id'];

// Fetch product details
$stmt = $pdo->prepare("SELECT * FROM inventory WHERE id = :id");
$stmt->execute([':id' => $id]);
$product = $stmt->fetch();

if (!$product) {
    header("Location: ../php/manage_inventory.php");
    exit();
}

// Handle product update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];
    $quantity = $_POST['quantity'];

    try {
        $update = $pdo->prepare("UPDATE inventory 
            SET product_name = :name, 
                price = :price, 
                image_url = :image_url,
                quantity = :quantity 
            WHERE id = :id");

        $update->execute([
            ':name' => $name,
            ':price' => $price,
            ':image_url' => $image_url,
            ':quantity' => $quantity,
            ':id' => $id
        ]);

        header("Location: ../php/manage_inventory.php");
        exit();
    } catch (PDOException $e) {
        die("Error updating product: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../css/editProduct.css">
</head>
<body>
    <h2>Edit Product</h2>

    <form method="POST" action="../php/editProduct.php?id=<?= $id; ?>">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['product_name']); ?>" required>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?= htmlspecialchars($product['price']); ?>" required>

        <label for="image_url">Image URL:</label>
        <input type="text" id="image_url" name="image_url" value="<?= htmlspecialchars($product['image_url']); ?>" required>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="<?= htmlspecialchars($product['quantity']); ?>" required>

        <button type="submit" name="update_product">Update Product</button>
    </form>
</body>
</html>
