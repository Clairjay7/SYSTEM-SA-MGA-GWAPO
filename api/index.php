<?php
// Load configuration
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/core/ApiResponse.php';
require_once __DIR__ . '/middleware/AuthMiddleware.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/OrderController.php';

// Enable CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 3600');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize authentication middleware
$auth = new AuthMiddleware();

// Initialize controllers
$authController = new AuthController($db, $auth);
$userController = new UserController($db, $auth);
$productController = new ProductController($db, $auth);
$orderController = new OrderController($db, $auth);

// Initialize router
$router = new Router();

// Auth routes (no auth required)
$router->addRoute('POST', '/auth/login', [$authController, 'login']);
$router->addRoute('POST', '/auth/guest', [$authController, 'continueAsGuest']);

// Protected routes (require authentication)
$authMiddleware = [$auth, 'authenticate'];

// User routes
$router->addRoute('GET', '/users', [$userController, 'getAll'], [$authMiddleware]);
$router->addRoute('GET', '/users/{id}', [$userController, 'getOne'], [$authMiddleware]);
$router->addRoute('PUT', '/users/{id}', [$userController, 'update'], [$authMiddleware]);
$router->addRoute('DELETE', '/users/{id}', [$userController, 'delete'], [$authMiddleware]);

// Product routes
$router->addRoute('GET', '/products', [$productController, 'getAll']);
$router->addRoute('GET', '/products/{id}', [$productController, 'getOne']);
$router->addRoute('POST', '/products', [$productController, 'create'], [$authMiddleware]);
$router->addRoute('PUT', '/products/{id}', [$productController, 'update'], [$authMiddleware]);
$router->addRoute('DELETE', '/products/{id}', [$productController, 'delete'], [$authMiddleware]);

// Order routes
$router->addRoute('GET', '/orders', [$orderController, 'getAll'], [$authMiddleware]);
$router->addRoute('GET', '/orders/{id}', [$orderController, 'getOne'], [$authMiddleware]);
$router->addRoute('POST', '/orders', [$orderController, 'create'], [$authMiddleware]);
$router->addRoute('PUT', '/orders/{id}', [$orderController, 'update'], [$authMiddleware]);
$router->addRoute('DELETE', '/orders/{id}', [$orderController, 'delete'], [$authMiddleware]);

// Handle the request
try {
    $router->handleRequest();
} catch (Exception $e) {
    ApiResponse::error('Internal Server Error: ' . $e->getMessage(), 500);
} 