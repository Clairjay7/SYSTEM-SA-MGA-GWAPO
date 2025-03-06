<?php
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty
$database = "codes"; // Change 'db' to 'codes'

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
