<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

// Get JSON input
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data || !isset($data['username']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing username or password']);
    exit;
}

$username = $data['username'];
$password = $data['password'];

try {
    // Get user from database
    $stmt = $pdo->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Start session and set user data
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        echo json_encode([
            'success' => true,
            'message' => 'Login successful',
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ]
        ]);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid username or password']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Login failed. Please try again.']);
}
?> 