<?php
require_once '../config/database.php';

try {
    // Read the SQL file
    $sql = file_get_contents('update_table.sql');
    
    // Execute the SQL
    $pdo->exec($sql);
    
    echo "Database updated successfully!";
} catch (PDOException $e) {
    echo "Error updating database: " . $e->getMessage();
}
?> 