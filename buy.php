<?php
session_start();
include 'connect.php'; // Connect to hotwheels_store DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $user_id = $_SESSION['user_id']; // Assuming user is logged in

    // Insert order into database
    $sql = "INSERT INTO orders (product_id, product_name, price, user_id) 
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isdi", $product_id, $product_name, $price, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Purchase successful!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error processing order');</script>";
    }
}
?>