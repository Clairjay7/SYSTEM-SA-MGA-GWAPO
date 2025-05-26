<?php
require_once __DIR__ . '/../core/BaseController.php';

class AuthController extends BaseController {
    public function login() {
        // Get request data
        $data = $this->getRequestData();
        
        // Validate required fields
        $this->validateRequired($data, ['username', 'password']);
        
        // Sanitize input
        $username = $this->sanitizeInput($data['username']);
        $password = $data['password'];

        try {
            // Check user credentials
            $stmt = $this->db->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !$this->verifyPassword($password, $user['password'])) {
                $this->sendError('Invalid credentials', 401);
            }

            // Generate token
            $token_data = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];

            $token = $this->auth->generateToken($token_data);

            // Send response
            $this->sendResponse([
                'token' => $token,
                'user' => $token_data
            ]);

        } catch (PDOException $e) {
            $this->sendError('Database error: ' . $e->getMessage(), 500);
        }
    }

    public function register() {
        // Get request data
        $data = $this->getRequestData();
        
        // Validate required fields
        $this->validateRequired($data, ['username', 'email', 'password']);
        
        // Validate email and password
        $this->validateEmail($data['email']);
        $this->validatePassword($data['password']);

        // Sanitize input
        $username = $this->sanitizeInput($data['username']);
        $email = $this->sanitizeInput($data['email']);
        $password = $this->hashPassword($data['password']);
        $role = 'user'; // Default role for new registrations

        try {
            // Check if username or email already exists
            $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            
            if ($stmt->rowCount() > 0) {
                $this->sendError('Username or email already exists', 400);
            }

            // Insert new user
            $stmt = $this->db->prepare("
                INSERT INTO users (username, email, password, role, created_at) 
                VALUES (?, ?, ?, ?, NOW())
            ");
            
            $stmt->execute([$username, $email, $password, $role]);
            
            // Get the new user's ID
            $userId = $this->db->lastInsertId();

            // Generate token
            $token_data = [
                'id' => $userId,
                'username' => $username,
                'role' => $role
            ];

            $token = $this->auth->generateToken($token_data);

            // Send response
            $this->sendResponse([
                'token' => $token,
                'user' => $token_data
            ]);

        } catch (PDOException $e) {
            $this->sendError('Database error: ' . $e->getMessage(), 500);
        }
    }

    public function logout() {
        // Since we're using JWT, we don't need to do anything server-side
        // The client should simply remove the token
        $this->sendResponse(['message' => 'Successfully logged out']);
    }
} 