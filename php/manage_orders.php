<?php
session_start();

// Ensure the user is logged in as an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../php/index.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CODES";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders from the database
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

// Update the order status if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $orderId = $_POST['order_id'];
    $status = $_POST['status'];

    // Update the status of the order
    $updateStmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $updateStmt->bind_param("si", $status, $orderId);
    $updateStmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link rel="stylesheet" href="../css/manage_orders.css">
</head>
<body>
    <header>
        <h1>Manage Orders</h1>
        <form action="../php/logout.php" method="POST" class="logout-form">
    <button type="submit" class="logout-button">Logout</button>
</form>

    </header>

    <div class="orders-container">
        <h2>Order List</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are any orders
                if ($result->num_rows > 0) {
                    // Loop through each row and display the order data
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["customer_name"] . "</td>
                                <td>" . $row["product_name"] . "</td>
                                <td>" . $row["quantity"] . "</td>
                                <td>";
                                    // Display the payment method correctly
                                    if ($row["payment_method"] == 'Cash') {
                                        echo 'Cash';
                                    } elseif ($row["payment_method"] == 'Paypal') {
                                        echo 'Paypal';
                                    } elseif ($row["payment_method"] == 'Gcash') {
                                        echo 'Gcash';
                                    } else {
                                        echo 'Unknown Payment Method';
                                    }
                        echo "</td>
                                <td>" . $row["status"] . "</td>
                                <td>
                                    <form method='POST'>
                                        <input type='hidden' name='order_id' value='" . $row["id"] . "'>
                                        <select name='status'>
                                            <option value='Pending' " . ($row["status"] == 'Pending' ? 'selected' : '') . ">Pending</option>
                                            <option value='Completed' " . ($row["status"] == 'Completed' ? 'selected' : '') . ">Completed</option>
                                        </select>
                                        <button type='submit'>Update Status</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
