<?php
session_start();
require_once '../php/connect.php'; // Ensures $pdo is available

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
    header("Location: ../php/manageUsers.php");
    exit();
}

// Update user data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // Get new password

    // Sanitize username to prevent XSS
    $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');

    // Check if password is provided, then hash it
    if (!empty($password)) {
        // Hash new password only if it's provided
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Update both username and password
        $stmt = $pdo->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
        $stmt->execute([$username, $hashedPassword, $id]);
    } else {
        // If password is not provided, only update the username
        $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->execute([$username, $id]);
    }

    $_SESSION['success'] = "User updated successfully!";
    header("Location: ../php/manageUsers.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User - Update Username and Password</title>
    <link rel="stylesheet" href="../css/updateUser.css">
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
            width: 300px;
        }
        input {
            margin-bottom: 10px;
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: blue;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
        }
        button:hover {
            background: darkblue;
        }
        a {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: blue;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit User - Update Username and Password</h2>

        <form method="POST">
            <input type="hidden" name="id" value="<?= isset($user['id']) ? htmlspecialchars($user['id']) : ''; ?>">
            
            <label>Username:</label>
            <input type="text" name="username" value="<?= isset($user['username']) ? htmlspecialchars($user['username']) : ''; ?>" required>

            <label>New Password (leave blank to keep current):</label>
            <input type="password" name="password">

            <button type="submit">Update User</button>
        </form>
        
        <a href="../php/manageUsers.php">Back to Manage Users</a>
    </div>
</body>
</html>
