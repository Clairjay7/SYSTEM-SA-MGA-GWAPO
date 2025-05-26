<?php
session_start();
require_once '../config/database.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verify POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Invalid request method";
    header("Location: shop.php");
    exit();
}

// Verify required fields
$required_fields = ['product_id', 'customer_name', 'quantity', 'payment_method', 'name', 'price'];
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        $_SESSION['error'] = "Missing required field: " . $field;
        header("Location: checkout.php");
        exit();
    }
}

// Get form data
$product_id = $_POST['product_id'];
$customer_name = $_POST['customer_name'];
$quantity = (int)$_POST['quantity'];
$payment_method = $_POST['payment_method'];
$product_name = $_POST['name'];
$price = (float)$_POST['price'];

try {
    // Start transaction
    $pdo->beginTransaction();

    // Check if product exists and has enough stock
    $stmt = $pdo->prepare("SELECT quantity FROM inventory WHERE id = ? AND quantity >= ?");
    $stmt->execute([$product_id, $quantity]);
    $product = $stmt->fetch();

    if (!$product) {
        throw new Exception("Product not available or insufficient stock");
    }

    // Calculate total amount
    $total_amount = $price * $quantity;

    // Create order with pending status
    $stmt = $pdo->prepare("
        INSERT INTO orders (
            product_id, 
            customer_name, 
            quantity, 
            price, 
            payment_method, 
            status
        ) VALUES (?, ?, ?, ?, ?, 'pending')
    ");
    
    $stmt->execute([
        $product_id,
        $customer_name,
        $quantity,
        $total_amount,
        $payment_method
    ]);
    
    $order_id = $pdo->lastInsertId();

    // Commit transaction
    $pdo->commit();

    // Store order details in session
    $_SESSION['order_details'] = [
        'order_id' => $order_id,
        'customer_name' => $customer_name,
        'product_name' => $product_name,
        'quantity' => $quantity,
        'price' => $price,
        'total_amount' => $total_amount,
        'payment_method' => $payment_method
    ];

    // Ensure the session is written
    session_write_close();

    // Redirect to receipt
    header("Location: receipt.php");
    exit();

} catch (Exception $e) {
    // Rollback transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    $_SESSION['error'] = "Error processing order: " . $e->getMessage();
    header("Location: checkout.php");
    exit();
}
?>
