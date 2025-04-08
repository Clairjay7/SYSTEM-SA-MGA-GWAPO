<?php
session_start();

// Hardcoded admin credentials (for testing purposes)
$admin_username = "Admin";
$admin_username = "AdminG";
$admin_username = "AdminGalorpot";
$admin_password_hash = password_hash("123", PASSWORD_DEFAULT); // Hashed version of "123"

// Check if form is submitted
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate credentials
    if ($username === $admin_username && password_verify($password, $admin_password_hash)) {
        // Set session for admin
        $_SESSION['admin_id'] = $username;
        $_SESSION['user_id'] = $username;
        $_SESSION['role'] = 'admin';

        // Redirect to admin dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Invalid login
        $_SESSION['error_message'] = "Invalid username or password.";
        header("Location: ../index.php"); // ✅ Redirect correctly to index.php
        exit();
    }
}
?>
