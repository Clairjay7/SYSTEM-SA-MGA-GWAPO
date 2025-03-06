<?php
session_start();
include 'connect.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    echo "<p>Please <a href='index.php'>login</a> to view your cart.</p>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for the logged-in user
$query = "SELECT cart.id AS cart_id, products.id AS product_id, products.name, products.price, products.image, cart.quantity
          FROM cart
          JOIN products ON cart.product_id = products.id
          WHERE cart.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$total_price = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <h1>Your Shopping Cart</h1>
    <table>
        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><img src="<?php echo $row['image']; ?>" width="50"></td>
                <td><?php echo $row['name']; ?></td>
                <td>$<?php echo number_format($row['price'], 2); ?></td>
                <td>
                    <form action="update_cart.php" method="POST">
                        <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                        <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" min="1">
                        <button type="submit">Update</button>
                    </form>
                </td>
                <td>$<?php echo number_format($row['price'] * $row['quantity'], 2); ?></td>
                <td>
                    <form action="remove_from_cart.php" method="POST">
                        <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                        <button type="submit">Remove</button>
                    </form>
                </td>
            </tr>
            <?php $total_price += $row['price'] * $row['quantity']; ?>
        <?php endwhile; ?>
    </table>
    <h3>Total: $<?php echo number_format($total_price, 2); ?></h3>
    <button onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
</body>
</html>
