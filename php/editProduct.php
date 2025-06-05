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
    $barcode = $_POST['barcode'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];
    $quantity = $_POST['quantity'];

    try {
        // Check if barcode already exists for another product
        if (!empty($barcode)) {
            $check = $pdo->prepare("SELECT id FROM inventory WHERE barcode = :barcode AND id != :id");
            $check->execute([':barcode' => $barcode, ':id' => $id]);
            if ($check->rowCount() > 0) {
                throw new Exception("This barcode is already in use by another product.");
            }
        }

        $update = $pdo->prepare("UPDATE inventory 
            SET product_name = :name,
                barcode = :barcode,
                price = :price, 
                image_url = :image_url,
                quantity = :quantity 
            WHERE id = :id");

        $update->execute([
            ':name' => $name,
            ':barcode' => $barcode ?: null,
            ':price' => $price,
            ':image_url' => $image_url,
            ':quantity' => $quantity,
            ':id' => $id
        ]);

        $_SESSION['success'] = "Product updated successfully!";
        header("Location: manage_inventory.php");
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../css/editProduct.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Product</h2>

        <form method="POST" action="../php/editProduct.php?id=<?= $id; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['product_name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="barcode" class="form-label">
                    <i class="fas fa-barcode"></i> Barcode:
                </label>
                <div class="input-group">
                    <input type="text" class="form-control" id="barcode" name="barcode" value="<?= htmlspecialchars($product['barcode'] ?? ''); ?>" maxlength="13">
                    <button type="button" class="btn btn-secondary" onclick="generateBarcode()">
                        <i class="fas fa-random"></i> Generate
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="text" class="form-control" id="price" name="price" value="<?= htmlspecialchars($product['price']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="image_url" class="form-label">Image URL:</label>
                <input type="text" class="form-control" id="image_url" name="image_url" value="<?= htmlspecialchars($product['image_url']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="<?= htmlspecialchars($product['quantity']); ?>" required>
            </div>

            <button type="submit" name="update_product" class="btn btn-primary">Update Product</button>
            <a href="manage_inventory.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Barcode generator function
        function generateBarcode() {
            // Generate a random 13-digit number (EAN-13 format)
            let barcode = '';
            for(let i = 0; i < 13; i++) {
                barcode += Math.floor(Math.random() * 10);
            }
            document.getElementById('barcode').value = barcode;
        }
    </script>
</body>
</html>
