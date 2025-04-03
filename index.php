<?php
session_start(); // Start the session at the very beginning

include('connect.php'); // Make sure your updated database connection file is correctly included

// Check if the user is already logged in (either as admin or as a guest)
if (isset($_SESSION['user_id']) || isset($_SESSION['guest'])) {
    // Redirect to homepage if logged in as an admin or a guest
    header("Location: homepage.php");
    exit();
}

// If "Continue as Guest" is clicked, start the guest session
if (isset($_GET['guest'])) {
    // Start the guest session
    $_SESSION['guest'] = true;

    // Generate a unique session ID for the guest
    $guest_session_id = session_id();

    try {
        // Insert the guest session into the database using PDO
        $stmt = $pdo->prepare("INSERT INTO guest_sessions (session_id) VALUES (:session_id)");
        $stmt->execute([':session_id' => $guest_session_id]); // Use execute() to bind the session ID

        // Redirect to homepage after successful guest login
        header("Location: homepage.php");
        exit();
    } catch (PDOException $e) {
        // Handle potential error in SQL query
        die("Error inserting guest session: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login or Continue as Guest</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <!-- Admin Login Box -->
        <div class="login-box">
            <h1>Admin Login</h1>
            <form action="login_action.php" method="post">
                <div class="input-group">
                    <label for="username">Admin Username</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" name="login" class="btn">Login</button>
            </form>
        </div>

        <!-- Or Section for Continue as Guest -->
        <div class="or">Or</div>
        
        <!-- Continue as Guest Link Styled as Button -->
        <a href="index.php?guest=true" class="guest-link">Continue if not Admin</a>
    </div>
</body>
</html>
