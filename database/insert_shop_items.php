<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'GALORPOT';

try {
    // Create connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected successfully<br>";
    
    // Read and execute the SQL file
    $sql = file_get_contents(__DIR__ . '/insert_shop_items.sql');
    
    // Execute each statement separately
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    foreach ($statements as $statement) {
        if ($statement) {
            $pdo->exec($statement);
            echo "Executed: " . substr($statement, 0, 50) . "...<br>";
        }
    }
    
    // Count the number of products
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM inventory");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<br>Successfully added " . $result['total'] . " products to the inventory!<br>";
    echo "You can now view these items in your shop.";
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?> 