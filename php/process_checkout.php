<?php
session_start();
include '../php/connect.php'; // Connect to DB

// Check if required POST data is set
if (isset($_POST['product_id'], $_POST['product_name'], $_POST['product_price'], $_POST['quantity'], $_POST['payment_method'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = (float) $_POST['product_price']; // convert to float
    $quantity = (int) $_POST['quantity'];             // convert to int
    $total_price = $product_price * $quantity;

    // Set customer name
    $customer_name = isset($_SESSION['user_id']) ? "User #" . $_SESSION['user_id'] : "Guest";

    // Get payment method from POST data
    $payment_method = $_POST['payment_method'];  // This will get the selected payment method from the form

    // Set order status based on payment method
    if ($payment_method == 'Cash') {
        $status = "Completed";  // If payment is cash, set status as completed
    } else {
        $status = "Pending";  // For Paypal and Gcash, keep the status as Pending
    }

    // Ensure that payment method is one of the expected values
    $valid_payment_methods = ['Cash', 'Paypal', 'Gcash'];
    if (!in_array($payment_method, $valid_payment_methods)) {
        echo "Invalid payment method!";
        exit();
    }

    // Start the transaction
    $pdo->beginTransaction();

    try {
        // Insert order details into orders table
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, product_name, quantity, price, payment_method, status) 
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$customer_name, $product_name, $quantity, $total_price, $payment_method, $status]);

        // Get the last inserted order ID
        $order_id = $pdo->lastInsertId();

        // Update inventory: Reduce stock after order is placed
        $stmt = $pdo->prepare("UPDATE inventory SET quantity = quantity - ? WHERE id = ?");
        $stmt->execute([$quantity, $product_id]);

        // Commit the transaction
        $pdo->commit();

        // Redirect to receipt page
        header("Location: receipt.php?order_id=" . $order_id);
        exit();
    } catch (Exception $e) {
        // If an error occurs, rollback the transaction
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid form submission!";
    exit();
}
