<?php
// Load environment variables from .env file (using phpdotenv library)
if (file_exists(__DIR__ . '/.env')) {
    require_once __DIR__ . '/vendor/autoload.php';  // Ensure you have phpdotenv installed via Composer
    Dotenv\Dotenv::createImmutable(__DIR__)->load();
}

// Database connection constants (using .env values or fallback to defaults)
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');  // Default to localhost if not set
define('DB_USER', getenv('DB_USER') ?: 'root');       // Default to 'root' if not set
define('DB_PASS', getenv('DB_PASS') ?: '');           // Default to empty string if not set
define('DB_NAME', getenv('DB_NAME') ?: 'GALORPOT');      // Default to 'codes' if not set

// Database connection using PDO
try {
    // Set up the Data Source Name (DSN) for MySQL
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";

    // Create a new PDO instance for the database connection
    $pdo = new PDO($dsn, DB_USER, DB_PASS);

    // Set PDO attributes for better error handling and data fetching
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions on errors
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Fetch results as associative arrays
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Disable prepared statement emulation for better performance

} catch (PDOException $e) {
    // Handle connection issues without exposing sensitive information
    error_log("Database connection error: " . $e->getMessage());  // Log the error to a file for troubleshooting
    die("Connection failed: Please try again later.");
}
?>
