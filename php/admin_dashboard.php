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
<<<<<<< HEAD
            <p>Manage your inventory, users, and orders efficiently.</p>
            <a href="../php/manage_inventory.php"><button>Manage Inventory</button></a>
            <a href="../php/manageUsers.php"><button>Manage Users</button></a>
            <a href="../php/manage_orders.php"><button>Manage Orders</button></a>
=======
            <p>Manage your inventory and users efficiently.</p>
            <a href="../php/manage_inventory.php"><button>Manage Inventory</button></a>
            <a href="../php/manageUsers.php"><button>Manage Users</button></a>
>>>>>>> c739b7baacb2d2ed47c87c308876a7249c13214a
            <a href="../php/homepage.php"><button>Go to Homepage</button></a>
        </div>
    </div>
</body>
</html>
