<?php
session_start();
require_once 'connect.php'; // Ensures $pdo is available

// Get user data
$user = [];
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
}

// If user is not found, redirect
if (!$user) {
    $_SESSION['error'] = "User not found.";
    header("Location: manageUsers.php");
    exit();
}

// Update user data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // Get new password

    // Hash the password before saving it
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Use prepared statements to prevent SQL injection
    $stmt = $pdo->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
    $stmt->execute([$username, $hashedPassword, $id]);

    $_SESSION['success'] = "User updated successfully!";
    header("Location: manageUsers.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User - Update Username and Password</title>
    <link rel="stylesheet" href="updateUser.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f0f4f8;
        }
        .container {
            text-align: center;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: white;
        }
        input {
            margin-bottom: 10px;
            padding: 8px;
            width: 100%;
        }
        button {
            background: blue;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: darkblue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit User - Update Username and Password</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?= isset($user['id']) ? htmlspecialchars($user['id']) : ''; ?>">
            <label>Username: <input type="text" name="username" value="<?= isset($user['username']) ? htmlspecialchars($user['username']) : ''; ?>" required></label><br>
            <label>New Password: <input type="password" name="password" required></label><br>
            <button type="submit">Update User</button>
        </form>
        <a href="manageUsers.php">Back to Manage Users</a>
    </div>
</body>
</html>
