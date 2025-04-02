<?php
session_start();

// Hardcoded admin credentials (for testing purposes)
// Hash the password once and store it in a database or somewhere secure
$admin_username = "Admin";
// Here, you hash the password "123" using `password_hash()`. In a real scenario, this should be stored securely in a database.
$admin_password_hash = password_hash("123", PASSWORD_DEFAULT);

// Check if form is submitted
if (isset($_POST['login'])) {
    // Get input values from form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if credentials match (checking username and using password_verify for the password)
    if ($username === $admin_username && password_verify($password, $admin_password_hash)) {
        // Set session for admin
        $_SESSION['admin_id'] = $username;

        // Redirect to admin dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Invalid credentials
        $_SESSION['error_message'] = "Invalid username or password.";
        header("Location: index.php");
        exit();
    }
}
?>
