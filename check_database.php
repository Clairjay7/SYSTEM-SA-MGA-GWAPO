<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'GALORPOT';

try {
    // Try to connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Successfully connected to database '$dbname'<br>";
    
    // Check if products table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'products'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Products table exists<br>";
        
        // Show table structure
        $stmt = $pdo->query("DESCRIBE products");
        echo "<br>Table structure:<br>";
        echo "<pre>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            print_r($row);
        }
        echo "</pre>";
        
        // Show any existing products
        $stmt = $pdo->query("SELECT * FROM products");
        echo "<br>Existing products:<br>";
        echo "<pre>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            print_r($row);
        }
        echo "</pre>";
    } else {
        echo "❌ Products table does not exist<br>";
    }
    
} catch(PDOException $e) {
    echo "❌ Database Error: " . $e->getMessage();
}
?> 