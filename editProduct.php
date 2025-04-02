<?php
session_start();
require_once 'connect.php';

// Check if user is logged in as an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the product data from the database
    $stmt = $pdo->prepare("SELECT * FROM inventory WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $product = $stmt->fetch();

    // If no product is found, redirect back
    if (!$product) {
        header("Location: manage_inventory.php");
        exit();
    }
} else {
    // If no ID is provided, redirect back
    header("Location: manage_inventory.php");
    exit();
}

// Update the product if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];
    $quantity = $_POST['quantity'];

    $update_sql = "UPDATE inventory SET product_name = :name, description = :description, price = :price, image_url = :image_url, quantity = :quantity WHERE id = :id";
    $stmt = $pdo->prepare($update_sql);
    $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':price' => $price,
        ':image_url' => $image_url,
        ':quantity' => $quantity,
        ':id' => $id
    ]);

    // Redirect back to manage inventory page after update
    header("Location: manage_inventory.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>
    <form method="POST" action="editProduct.php?id=<?php echo $id; ?>">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>

        <label for="image_url">Image URL:</label>
        <input type="text" id="image_url" name="image_url" value="<?php echo htmlspecialchars($product['image_url']); ?>" required>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required>

        <button type="submit" name="update_product">Update Product</button>
    </form>
</body>
</html>
