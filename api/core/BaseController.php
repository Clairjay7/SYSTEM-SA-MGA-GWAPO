<?php
class BaseController {
    protected $db;
    protected $auth;

    public function __construct($db, $auth) {
        $this->db = $db;
        $this->auth = $auth;
    }

    protected function getRequestData() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->sendError('Invalid JSON data', 400);
        }
        return $data;
    }

    protected function sendResponse($data, $code = 200) {
        http_response_code($code);
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
        exit();
    }

    protected function sendError($message, $code = 400) {
        http_response_code($code);
        echo json_encode([
            'status' => 'error',
            'code' => $code,
            'message' => $message
        ]);
        exit();
    }

    protected function validateRequired($data, $fields) {
        foreach ($fields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $this->sendError("Missing required field: $field", 400);
            }
        }
    }

    protected function sanitizeInput($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->sanitizeInput($value);
            }
        } else {
            $data = strip_tags(trim($data));
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }
        return $data;
    }

    protected function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->sendError('Invalid email format', 400);
        }
    }

    protected function validatePassword($password) {
        if (strlen($password) < 8) {
            $this->sendError('Password must be at least 8 characters long', 400);
        }
    }

    protected function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    protected function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    protected function getCurrentUser() {
        return isset($_REQUEST['user']) ? $_REQUEST['user'] : null;
    }

    protected function isAdmin() {
        $user = $this->getCurrentUser();
        return isset($user['role']) && $user['role'] === 'admin';
    }

    protected function checkAdminAccess() {
        if (!$this->isAdmin()) {
            $this->sendError('Admin access required', 403);
        }
    }
} 