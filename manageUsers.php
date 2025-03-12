<?php
session_start();
require_once 'connect.php';

// DELETE user
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id = $id");
    $_SESSION['success'] = "User deleted successfully!";
    header("Location: manageUsers.php");
    exit();
}

// FETCH users
$result = $conn->query("SELECT id, username, email, created_at FROM users");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="manageUsers.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
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
        .back-link {
            align-self: flex-start;
            margin: 20px;
        }
        table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <a class="back-link" href="homepage.php">Back to Dashboard</a>
    <div class="container">
        <h1>Manage Users</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <p style="color: green;"> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?> </p>
        <?php endif; ?>

        <table border="1">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            <?php while ($user = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $user['id']; ?></td>
                    <td><?= htmlspecialchars($user['username']); ?></td>
                    <td><?= htmlspecialchars($user['email']); ?></td>
                    <td><?= $user['created_at']; ?></td>
                    <td>
                        <a href="updateUser.php?id=<?= $user['id']; ?>">Edit</a>
                        <a href="manageUsers.php?delete=<?= $user['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>