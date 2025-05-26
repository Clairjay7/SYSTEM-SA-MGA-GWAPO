<?php
require_once __DIR__ . '/../auth/JWTHandler.php';

class AuthMiddleware {
    private $jwt;
    private $excludedRoutes = [
        '/auth/login',
        '/auth/register'
    ];

    public function __construct() {
        $this->jwt = new JWTHandler();
    }

    public function authenticate() {
        // Skip authentication for excluded routes
        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $apiPath = str_replace('/api/' . API_VERSION, '', $currentPath);
        
        if (in_array($apiPath, $this->excludedRoutes)) {
            return true;
        }

        // Get headers
        $headers = getallheaders();
        
        // Check for Authorization header
        if (!isset($headers['Authorization'])) {
            $this->sendError('Authorization header not found', 401);
            return false;
        }

        // Extract token
        $auth_header = $headers['Authorization'];
        if (!preg_match('/Bearer\s(\S+)/', $auth_header, $matches)) {
            $this->sendError('Invalid authorization format', 401);
            return false;
        }

        $token = $matches[1];
        
        // Validate token
        $decoded = $this->jwt->validateToken($token);
        if (!$decoded) {
            $this->sendError('Invalid or expired token', 401);
            return false;
        }

        // Add user data to request
        $_REQUEST['user'] = $decoded['user'];
        return true;
    }

    public function checkRole($required_role) {
        if (!isset($_REQUEST['user']) || !isset($_REQUEST['user']['role'])) {
            $this->sendError('User role not found', 403);
            return false;
        }

        $user_role = $_REQUEST['user']['role'];
        
        // Admin has access to everything
        if ($user_role === 'admin') {
            return true;
        }

        // Check if user has required role
        if ($user_role !== $required_role) {
            $this->sendError('Insufficient permissions', 403);
            return false;
        }

        return true;
    }

    private function sendError($message, $code) {
        http_response_code($code);
        echo json_encode([
            'status' => 'error',
            'code' => $code,
            'message' => $message
        ]);
        exit();
    }
} 