<?php
// orders.php

header("Content-Type: application/json");
require_once '../php/connect.php';

// Handle GET request to fetch all orders
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->query("SELECT * FROM orders");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($orders);
}

// Handle POST request to create a new order
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['customer_name']) || !isset($data['product_name']) || !isset($data['quantity'])) {
        echo json_encode(["message" => "Required fields: customer_name, product_name, quantity"]);
        exit();
    }

    $customerName = htmlspecialchars($data['customer_name'], ENT_QUOTES, 'UTF-8');
    $productName = htmlspecialchars($data['product_name'], ENT_QUOTES, 'UTF-8');
    $quantity = $data['quantity'];

    $stmt = $pdo->prepare("INSERT INTO orders (customer_name, product_name, quantity, status) VALUES (?, ?, ?, 'Pending')");
    $stmt->execute([$customerName, $productName, $quantity]);

    echo json_encode(["message" => "Order created successfully"]);
}

// Handle PUT request to update order status
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id']) || !isset($data['status'])) {
        echo json_encode(["message" => "Order ID and status are required"]);
        exit();
    }

    $id = $data['id'];
    $status = htmlspecialchars($data['status'], ENT_QUOTES, 'UTF-8');

    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);

    echo json_encode(["message" => "Order status updated successfully"]);
}

// Handle DELETE request to delete an order
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data['id'])) {
        echo json_encode(["message" => "Order ID required"]);
        exit();
    }

    $id = $data['id'];

    $stmt = $pdo->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(["message" => "Order deleted successfully"]);
}
?>
