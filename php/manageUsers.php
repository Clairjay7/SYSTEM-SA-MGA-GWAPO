<?php
session_start();
require_once '../php/connect.php'; // Ensure the connection is established

<<<<<<< HEAD
// Include helper function to fetch data from the API
function get_data_from_api($endpoint) {
    $url = "http://localhost/SYSTEM-SA-MGA-GWAPO/api/$endpoint";
    
    // Adjust API URL as needed
    $response = file_get_contents($url);
    return json_decode($response, true);
}

// Fetch users from the API (instead of querying the database directly)
$users = get_data_from_api('users.php'); // Removed ../api
$guests = get_data_from_api('guest_sessions.php'); // Removed ../api
=======
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
>>>>>>> c739b7baacb2d2ed47c87c308876a7249c13214a

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Users</title>
<<<<<<< HEAD
=======
    <!-- Link to the external CSS file -->
>>>>>>> c739b7baacb2d2ed47c87c308876a7249c13214a
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
<<<<<<< HEAD
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id']; ?></td>
                        <td><?= htmlspecialchars($user['username']); ?></td>
                        <td><?= $user['created_at']; ?></td>
                        <td>Admin</td>
                        <td>
                            <a href="../php/updateUser.php?id=<?= $user['id']; ?>">Edit</a>
                            <a href="#" onclick="deleteUser(<?= $user['id']; ?>)">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">No users found</td></tr>
            <?php endif; ?>

            <!-- Display Guest Users -->
            <?php if (!empty($guests)): ?>
                <?php foreach ($guests as $guest): ?>
                    <tr>
                        <td><?= $guest['id']; ?></td>
                        <td><?= htmlspecialchars($guest['session_id']); ?></td>
                        <td><?= $guest['created_at']; ?></td>
                        <td>Guest</td>
                        <td>
                            <a href="#" onclick="alert('Guest users cannot be edited!'); return false;">Edit</a>
                            <a href="#" onclick="alert('Guest users cannot be deleted!'); return false;">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">No guest sessions found</td></tr>
            <?php endif; ?>

        </table>
    </div>

    <script>
        // Function to delete a user via API
        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                fetch('http://localhost/SYSTEM-SA-MGA-GWAPO/api/users.php', {
                    method: 'DELETE',
                    body: JSON.stringify({ id: userId }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    // Optionally, refresh the page or remove the user from the table dynamically
                    window.location.reload();
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>

=======
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
>>>>>>> c739b7baacb2d2ed47c87c308876a7249c13214a
</body>
</html>
