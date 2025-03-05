<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inventory</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <nav class="navbar">
        <h1>Manage Inventory</h1>
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="#">Shop</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href='logout.php'>Logout</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <!-- Back Button (Upper Left Below Title) -->
        <div class="back-button-container">
            <button class="back-btn" onclick="location.href='homepage.php'">Back</button>
        </div>

        <section class="inventory-section">
            <h1>Manage Inventory</h1>
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Hot Wheels Super Speedster</td>
                        <td>$9.99</td>
                        <td>15</td>
                        <td>
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Classic Racer</td>
                        <td>$12.99</td>
                        <td>8</td>
                        <td>
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
