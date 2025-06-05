<?php
require_once '../config/database.php';

try {
    // Create products table
    $sql = "CREATE TABLE IF NOT EXISTS products (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(10,2) NOT NULL,
        category VARCHAR(100),
        brand VARCHAR(100),
        sku VARCHAR(50) UNIQUE,
        stock_quantity INT NOT NULL DEFAULT 0,
        image_url VARCHAR(255),
        status ENUM('active', 'inactive', 'discontinued') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "Products table created successfully!\n";
    
} catch (PDOException $e) {
    die("Error creating tables: " . $e->getMessage());
} 