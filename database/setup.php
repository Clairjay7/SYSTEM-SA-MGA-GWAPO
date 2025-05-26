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
    $sql = file_get_contents(__DIR__ . '/complete_setup.sql');
    
    // Execute each statement separately
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    foreach ($statements as $statement) {
        if ($statement) {
            $pdo->exec($statement);
            echo "Executed: " . substr($statement, 0, 50) . "...<br>";
        }
    }
    
    echo "<br>Database setup completed successfully!<br>";
    echo "You can now log in with:<br>";
    echo "Username: admin<br>";
    echo "Password: password";
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?> 