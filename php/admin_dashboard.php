<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../php/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin_dashboard.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <a href="../php/logout.php" class="logout">Logout</a>
    </header>
    
    <div class="dashboard-container">
        <div class="card">
            <h2>Welcome, Admin</h2>
            <p>Manage your inventory, users, and orders efficiently.</p>
        </div>

        <div class="actions">
            <a href="../php/manage_inventory.php" class="action-card">
                <div class="action-content">
                    <h3>Manage Inventory</h3>
                    <p>Update and track your inventory items.</p>
                </div>
            </a>
            <a href="../php/manageUsers.php" class="action-card">
                <div class="action-content">
                    <h3>Manage Users</h3>
                    <p>View and manage user accounts.</p>
                </div>
            </a>
            <a href="../php/manage_orders.php" class="action-card">
                <div class="action-content">
                    <h3>Manage Orders</h3>
                    <p>Track and process customer orders.</p>
                </div>
            </a>
            <a href="../php/homepage.php" class="action-card">
                <div class="action-content">
                    <h3>Go to Homepage</h3>
                    <p>Return to the main website.</p>
                </div>
            </a>
        </div>
    </div>
</body>
</html>