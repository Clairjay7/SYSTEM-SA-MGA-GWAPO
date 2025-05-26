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
    $_SESSION['error'] = "No guest session ID provided";
    header("Location: manage_users.php");
    exit();
}

try {
    // Update the guest session status to inactive
    $stmt = $pdo->prepare("UPDATE guest_sessions SET status = 'inactive' WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    
    if ($stmt->rowCount() > 0) {
        $_SESSION['success'] = "Guest session ended successfully";
    } else {
        $_SESSION['error'] = "Guest session not found";
    }
} catch(PDOException $e) {
    $_SESSION['error'] = "Error ending guest session: " . $e->getMessage();
}

header("Location: manage_users.php");
exit(); 