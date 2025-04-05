<?php
// products.php

header("Content-Type: application/json");
require_once '../php/connect.php';

// Handle GET request to fetch all products
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Use the inventory table instead of products
    $stmt = $pdo->query("SELECT * FROM inventory");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($products);
}

// Handle POST request to create a new product
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['name']) || !isset($data['price']) || !isset($data['quantity'])) {
        echo json_encode(["message" => "Required fields: name, price, quantity"]);
        exit();
    }

    $name = htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');
    $price = $data['price'];
    $quantity = $data['quantity'];

    // Use the inventory table instead of products
    $stmt = $pdo->prepare("INSERT INTO inventory (name, price, quantity) VALUES (?, ?, ?)");
    $stmt->execute([$name, $price, $quantity]);

    echo json_encode(["message" => "Product created successfully"]);
}

// Handle PUT request to update product details
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id']) || !isset($data['name'])) {
        echo json_encode(["message" => "Product ID and name are required"]);
        exit();
    }

    $id = $data['id'];
    $name = htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');
    $price = isset($data['price']) ? $data['price'] : null;
    $quantity = isset($data['quantity']) ? $data['quantity'] : null;

    // Update query for the inventory table
    if ($price && $quantity) {
        $stmt = $pdo->prepare("UPDATE inventory SET name = ?, price = ?, quantity = ? WHERE id = ?");
        $stmt->execute([$name, $price, $quantity, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE inventory SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);
    }

    echo json_encode(["message" => "Product updated successfully"]);
}

// Handle DELETE request to delete a product
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id'])) {
        echo json_encode(["message" => "Product ID required"]);
        exit();
    }

    $id = $data['id'];

    // Use the inventory table instead of products
    $stmt = $pdo->prepare("DELETE FROM inventory WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(["message" => "Product deleted successfully"]);
}
?>
