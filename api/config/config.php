<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'galorpot');
define('DB_USER', 'root');
define('DB_PASS', '');

// JWT configuration
define('JWT_SECRET_KEY', 'your-secret-key-here');
define('JWT_TOKEN_EXPIRE', 3600); // 1 hour

// API Version
define('API_VERSION', 'v1');

// CORS Settings
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Authorization, Content-Type');
header('Content-Type: application/json');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Time zone
date_default_timezone_set('Asia/Manila');

// Rate limiting
define('RATE_LIMIT_PER_MINUTE', 100); 