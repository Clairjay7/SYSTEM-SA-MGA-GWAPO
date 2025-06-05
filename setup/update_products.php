<?php
require_once '../config/database.php';

try {
    // Read the SQL file
    $sql = file_get_contents('update_products_table.sql');
    
    // Execute the SQL
    $pdo->exec($sql);
    
    echo "Products table updated successfully!";
} catch (PDOException $e) {
    echo "Error updating products table: " . $e->getMessage();
}
?> 