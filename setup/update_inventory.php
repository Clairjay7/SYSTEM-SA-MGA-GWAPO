<?php
require_once '../config/database.php';

try {
    // Read the SQL file
    $sql = file_get_contents('update_inventory_table.sql');
    
    // Execute the SQL
    $pdo->exec($sql);
    
    echo "Inventory table updated successfully!";
} catch (PDOException $e) {
    echo "Error updating inventory table: " . $e->getMessage();
}
?> 