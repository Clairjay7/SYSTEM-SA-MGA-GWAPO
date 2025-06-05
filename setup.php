<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Create PDO connection without database name
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS GALORPOT");
    echo "Database 'GALORPOT' created or already exists.<br>";
    
    // Select the database
    $pdo->exec("USE GALORPOT");
    
    // Create products table
    $sql = "CREATE TABLE IF NOT EXISTS products (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL,
        category VARCHAR(100),
        brand VARCHAR(100),
        sku VARCHAR(50) NULL UNIQUE,
        stock_quantity INT NOT NULL DEFAULT 0,
        image_url VARCHAR(255),
        status ENUM('active', 'inactive', 'discontinued') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "Products table created successfully.<br>";
    
    // Create images directory if it doesn't exist
    $imageDir = __DIR__ . '/images/products';
    if (!file_exists($imageDir)) {
        mkdir($imageDir, 0777, true);
        echo "Created images directory at: $imageDir<br>";
    }
    
    // Create logs directory if it doesn't exist
    $logsDir = __DIR__ . '/logs';
    if (!file_exists($logsDir)) {
        mkdir($logsDir, 0777, true);
        echo "Created logs directory at: $logsDir<br>";
    }
    
    echo "<br>Setup completed successfully!<br>";
    echo "You can now use the add products feature.";
    
} catch(PDOException $e) {
    die("Setup failed: " . $e->getMessage());
}
?> 