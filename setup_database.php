<?php
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Create connection
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected successfully<br>";
    
    // Read and execute the SQL file
    $sql = file_get_contents('database/setup_database.sql');
    
    // Execute each statement separately
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    foreach ($statements as $statement) {
        if ($statement) {
            $pdo->exec($statement);
            echo "Executed: " . substr($statement, 0, 50) . "...<br>";
        }
    }
    
    echo "Database setup completed successfully!";
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?> 