<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
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
        <a href="logout.php" class="logout">Logout</a>
    </header>
    
    <div class="dashboard-container">
        <div class="card">
            <h2>Welcome, Admin</h2>
            <p>Manage your inventory and users efficiently.</p>
            <a href="manage_inventory.php"><button>Manage Inventory</button></a>
            <a href="manageUsers.php"><button>Manage Users</button></a>
        </div>
    </div>
</body>
</html>
