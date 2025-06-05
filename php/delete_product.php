<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Check if ID is provided
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "No product ID provided";
    header("Location: manage_products.php");
    exit();
}

try {
    // Start transaction
    $pdo->beginTransaction();

    // Instead of deleting, mark the product as deleted
    $stmt = $pdo->prepare("
        UPDATE inventory 
        SET deleted_at = CURRENT_TIMESTAMP
        WHERE id = ?
    ");
    $stmt->execute([$_GET['id']]);

    // Commit transaction
    $pdo->commit();

    $_SESSION['success'] = "Product marked as deleted successfully";
} catch(PDOException $e) {
    // Rollback transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['error'] = "Error deleting product: " . $e->getMessage();
}

header("Location: manage_products.php");
exit(); 