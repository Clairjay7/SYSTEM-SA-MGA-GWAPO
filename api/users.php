<?php
// users.php

header("Content-Type: application/json");
require_once '../php/connect.php';

// Handle GET request to fetch all users
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch users from database
    $stmt = $pdo->query("SELECT id, username, created_at FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($users);
}

// Handle POST request to create a new user
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['username']) || !isset($data['password'])) {
        echo json_encode(["message" => "Username and password required"]);
        exit();
    }

    $username = htmlspecialchars($data['username'], ENT_QUOTES, 'UTF-8');
    $password = password_hash($data['password'], PASSWORD_BCRYPT);

    // Insert user into database
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);

    echo json_encode(["message" => "User created successfully"]);
}

// Handle PUT request to update an existing user
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data['id']) || !isset($data['username'])) {
        echo json_encode(["message" => "ID and username are required"]);
        exit();
    }

    $id = $data['id'];
    $username = htmlspecialchars($data['username'], ENT_QUOTES, 'UTF-8');
    $password = isset($data['password']) ? password_hash($data['password'], PASSWORD_BCRYPT) : null;

    // Update the user
    if ($password) {
        $stmt = $pdo->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
        $stmt->execute([$username, $password, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->execute([$username, $id]);
    }

    echo json_encode(["message" => "User updated successfully"]);
}

// Handle DELETE request to delete a user
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data['id'])) {
        echo json_encode(["message" => "User ID required"]);
        exit();
    }

    $id = $data['id'];

    // Delete user from the database
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(["message" => "User deleted successfully"]);
}
?>
