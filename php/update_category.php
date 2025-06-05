<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Check if POST data is set
if (!isset($_POST['product_id']) || !isset($_POST['category'])) {
    $_SESSION['error'] = "Missing required fields";
    header("Location: manage_products.php");
    exit();
}

$product_id = $_POST['product_id'];
$category = $_POST['category'];

// Validate category
$valid_categories = ['Regular', 'Premium', 'Limited Edition'];
if (!in_array($category, $valid_categories)) {
    $_SESSION['error'] = "Invalid category";
    header("Location: manage_products.php");
    exit();
}

try {
    // Update the category
    $stmt = $pdo->prepare("UPDATE inventory SET category = ? WHERE id = ?");
    $stmt->execute([$category, $product_id]);

    $_SESSION['success'] = "Product category updated successfully";
} catch(PDOException $e) {
    $_SESSION['error'] = "Error updating category: " . $e->getMessage();
}

header("Location: manage_products.php");
exit(); 