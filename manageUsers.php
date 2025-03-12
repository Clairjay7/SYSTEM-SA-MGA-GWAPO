<?php
session_start();
require_once 'connect.php';; // Ensure DB connection

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
</head>
<body>
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

    <br>
    <a href="homepage.php">Back to Dashboard</a>
</body>
</html>
