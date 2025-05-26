<?php
session_start();
require_once '../config/database.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // For debugging
    error_log("Login attempt - Username: " . $username);

    try {
        // Get user from database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // For debugging
        error_log("User found: " . ($user ? 'Yes' : 'No'));
        
        // Check if user exists and is an admin
        if ($user && $user['role'] === 'admin') {
            // For admin accounts, check if password is '123' or matches hashed password
            if ($password === '123' || password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = 'admin';
                
                // For debugging
                error_log("Admin login successful - Redirecting to admin dashboard");
                
                header("Location: admin_dashboard.php");
                exit();
            }
        }
        // Regular user login check
        else if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            header("Location: homepage.php");
            exit();
        }
        
        // If we get here, login failed
        $_SESSION['error'] = "Invalid username or password";
        error_log("Login failed - Invalid credentials");
        header("Location: ../index.php");
        exit();
        
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $_SESSION['error'] = "Login failed. Please try again.";
        header("Location: ../index.php");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>