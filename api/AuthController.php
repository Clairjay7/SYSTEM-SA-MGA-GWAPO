<?php
require_once __DIR__ . '/../core/BaseController.php';

class AuthController extends BaseController {
    public function login() {
        try {
            error_log("Login attempt started");
            
            // Get request data
            $data = $this->getRequestData();
            error_log("Login data received: " . print_r($data, true));
            
            // Validate required fields
            if (!isset($data['username']) || !isset($data['password'])) {
                error_log("Missing login credentials");
                $this->sendError('Username and password are required', 400);
                return;
            }
            
            // Sanitize input
            $username = $this->sanitizeInput($data['username']);
            $password = $data['password'];
            error_log("Attempting login for username: " . $username);

            // Check user credentials
            $stmt = $this->db->prepare("
                SELECT id, username, password, role 
                FROM users 
                WHERE username = ? AND status = 'active'
            ");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                error_log("User not found: " . $username);
                $this->sendError('Invalid credentials', 401);
                return;
            }

            if (!password_verify($password, $user['password'])) {
                error_log("Invalid password for user: " . $username);
                $this->sendError('Invalid credentials', 401);
                return;
            }

            error_log("User authenticated successfully: " . $username);

            // Generate token
            $token_data = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];

            $token = $this->auth->generateToken($token_data);
            error_log("Token generated for user: " . $username);

            // Send response
            $this->sendResponse([
                'token' => $token,
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ]
            ], 'Login successful');

        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->sendError('Login failed: ' . $e->getMessage(), 500);
        }
    }

    public function continueAsGuest() {
        try {
            // Get client information
            $session_id = session_id();
            $ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
            $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
            
            // Create a guest session
            $stmt = $this->db->prepare("
                INSERT INTO guest_sessions (session_id, ip_address, user_agent, created_at, last_activity, status) 
                VALUES (?, ?, ?, NOW(), NOW(), 'active')
            ");
            $stmt->execute([$session_id, $ip_address, $user_agent]);
            
            $guestId = $this->db->lastInsertId();
            
            // Generate guest token
            $token_data = [
                'id' => $guestId,
                'role' => 'guest',
                'type' => 'guest_session'
            ];
            
            $token = $this->auth->generateToken($token_data);
            
            // Send response
            $this->sendResponse([
                'token' => $token,
                'user' => [
                    'id' => $guestId,
                    'role' => 'guest'
                ]
            ], 'Guest session created successfully');
            
        } catch (Exception $e) {
            $this->sendError('Failed to create guest session: ' . $e->getMessage(), 500);
        }
    }

    public function logout() {
        $this->sendResponse(null, 'Successfully logged out');
    }
} 