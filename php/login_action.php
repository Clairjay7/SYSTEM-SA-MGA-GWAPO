<?php
session_start();
require_once '../config/database.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// For debugging
echo "<pre>";
echo "POST data received:\n";
print_r($_POST);
echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (empty($username) || empty($password)) {
        echo "<script>
            alert('Please enter both username and password');
            window.location.href='../index.php';
        </script>";
        exit();
    }

    try {
        // Get user from database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        echo "<pre>";
        echo "Database query result:\n";
        print_r($user);
        echo "</pre>";

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            echo "<pre>";
            echo "Login successful!\n";
            echo "Session data:\n";
            print_r($_SESSION);
            echo "\nRedirecting in 3 seconds...\n";
            echo "</pre>";

            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: homepage.php");
            }
            exit();
        } else {
            if (!$user) {
                echo "<script>
                    alert('Username not found');
                    window.location.href='../index.php';
                </script>";
            } else {
                echo "<script>
                    alert('Incorrect password');
                    window.location.href='../index.php';
                </script>";
            }
            exit();
        }
    } catch (PDOException $e) {
        echo "<script>
            alert('A system error occurred. Please try again later.');
            window.location.href='../index.php';
        </script>";
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>