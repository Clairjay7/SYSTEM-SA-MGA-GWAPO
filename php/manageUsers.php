<?php
session_start();
require_once '../php/connect.php'; // Ensure the connection is established

// DELETE user (only applies to registered users)
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $pdo->query("DELETE FROM users WHERE id = $id");
    $_SESSION['success'] = "User deleted successfully!";
    header("Location: ../php/manageUsers.php");
    exit();
}

// FETCH admin users
$stmtUsers = $pdo->query("SELECT id, username, created_at FROM users");

// FETCH guest users
$stmtGuests = $pdo->query("SELECT id, session_id AS username, created_at FROM guest_sessions");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Users</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="../css/manageUsers.css">
</head>
<body>

    <a class="back-link" href="../php/admin_dashboard.php">← Back to Dashboard</a>

    <div class="container">
        <h1 class="center-title">Manage Users</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <p style="color: green;"> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?> </p>
        <?php endif; ?>

        <table border="1">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Created At</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
            
            <!-- Display Registered Users (Admins) -->
            <?php while ($user = $stmtUsers->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= $user['id']; ?></td>
                    <td><?= htmlspecialchars($user['username']); ?></td>
                    <td><?= $user['created_at']; ?></td>
                    <td>Admin</td>
                    <td>
                        <a href="../php/updateUser.php?id=<?= $user['id']; ?>">Edit</a>
                        <a href="../php/manageUsers.php?delete=<?= $user['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>

            <!-- Display Guest Users -->
            <?php while ($guest = $stmtGuests->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?= $guest['id']; ?></td>
                    <td><?= htmlspecialchars($guest['username']); ?></td>
                    <td><?= $guest['created_at']; ?></td>
                    <td>Guest</td>
                    <td>
                        <a href="#" onclick="alert('Guest users cannot be edited!'); return false;">Edit</a>
                        <a href="#" onclick="alert('Guest users cannot be deleted!'); return false;">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>

        </table>
    </div>
</body>
</html>
