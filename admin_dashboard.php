<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // Redirect to login if not an Admin
    exit();
}

// Admin dashboard content here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>
    <div style="text-align: center; margin-top: 20px;">
        <a href="logout.php">Logout</a>
        <br><br>
        <!-- Add admin-specific buttons for managing inventory and users -->
        <a href="manage_inventory.php">
            <button>Manage Inventory</button>
        </a>
        <br><br>
        <a href="manageUsers.php">
            <button>Manage Users</button>
        </a>
    </div>
</body>
</html>
