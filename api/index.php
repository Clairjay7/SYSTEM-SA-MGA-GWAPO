<?php
// Load configuration
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/middleware/AuthMiddleware.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/UserController.php';

// Handle CORS preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize authentication middleware
$auth = new AuthMiddleware();

// Parse the request URI
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$api_path = str_replace('/api/' . API_VERSION, '', $request_uri);
$path_parts = explode('/', trim($api_path, '/'));
$resource = $path_parts[0] ?? '';
$id = $path_parts[1] ?? null;
$action = $path_parts[2] ?? null;

// Route the request
try {
    // Authenticate request (except for login/register)
    if (!$auth->authenticate()) {
        exit();
    }

    switch ($resource) {
        case 'auth':
            $controller = new AuthController($db, $auth);
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    if ($action === 'login') {
                        $controller->login();
                    } elseif ($action === 'register') {
                        $controller->register();
                    } elseif ($action === 'logout') {
                        $controller->logout();
                    }
                    break;
            }
            break;

        case 'users':
            $controller = new UserController($db, $auth);
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    if ($id) {
                        $controller->getOne($id);
                    } else {
                        $controller->getAll();
                    }
                    break;
                case 'PUT':
                    if ($id) {
                        $controller->update($id);
                    }
                    break;
                case 'DELETE':
                    if ($id) {
                        $controller->delete($id);
                    }
                    break;
            }
            break;

        default:
            // Handle 404 Not Found
            http_response_code(404);
            echo json_encode([
                'status' => 'error',
                'code' => 404,
                'message' => 'Resource not found'
            ]);
            break;
    }
} catch (Exception $e) {
    // Handle any uncaught exceptions
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'code' => 500,
        'message' => 'Internal server error: ' . $e->getMessage()
    ]);
} 