<?php
session_start();
require_once 'connect.php';; // Database connection
include 'functions.php'; // CRUD functions

// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signIn'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $user = getUserByEmail($conn, $email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['success'] = 'Login successful!';
        header('Location: homepage.php');
        exit();
    } else {
        $_SESSION['error'] = 'Invalid email or password!';
    }
}

// Handle registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signUp'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (userExists($conn, $email, $username)) {
        $_SESSION['error'] = 'Email or username already taken!';
        header('Location: index.php');
        exit();
    }

    if (createUser($conn, $username, $email, $password)) {
        $_SESSION['success'] = 'Registration successful! You can now log in.';
        header('Location: index.php');
        exit();
    } else {
        $_SESSION['error'] = 'Registration failed. Try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <!-- Sign In Form -->
    <div class="container" id="signIn">
        <h1 class="form-title">Sign In</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <p class="error-message"> <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?> </p>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <p class="success-message"> <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?> </p>
        <?php endif; ?>

        <form method="post" action="">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>
        <p class="or">----------or--------</p>
        <div class="links">
            <button id="signUpButton">Sign Up</button>
        </div>
    </div>

    <!-- Sign Up Form -->
    <div class="container" id="signUp" style="display: none;">
        <h1 class="form-title">Sign Up</h1>
        <form method="post" action="">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <input type="submit" class="btn" value="Sign Up" name="signUp">
        </form>
        <p class="or">----------or--------</p>
        <div class="links">
            <button id="signInButton">Back to Sign In</button>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>