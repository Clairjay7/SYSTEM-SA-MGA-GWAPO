<?php
require_once __DIR__ . '/../core/BaseController.php';

class UserController extends BaseController {
    public function getAll() {
        // Check admin access
        $this->checkAdminAccess();

        try {
            $stmt = $this->db->prepare("
                SELECT id, username, email, role, created_at 
                FROM users 
                ORDER BY created_at DESC
            ");
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $this->sendResponse(['users' => $users]);
        } catch (PDOException $e) {
            $this->sendError('Database error: ' . $e->getMessage(), 500);
        }
    }

    public function getOne($id) {
        // Check if user is admin or requesting their own data
        $currentUser = $this->getCurrentUser();
        if (!$this->isAdmin() && $currentUser['id'] != $id) {
            $this->sendError('Access denied', 403);
        }

        try {
            $stmt = $this->db->prepare("
                SELECT id, username, email, role, created_at 
                FROM users 
                WHERE id = ?
            ");
            $stmt->execute([$id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                $this->sendError('User not found', 404);
            }

            $this->sendResponse(['user' => $user]);
        } catch (PDOException $e) {
            $this->sendError('Database error: ' . $e->getMessage(), 500);
        }
    }

    public function update($id) {
        // Check if user is admin or updating their own data
        $currentUser = $this->getCurrentUser();
        if (!$this->isAdmin() && $currentUser['id'] != $id) {
            $this->sendError('Access denied', 403);
        }

        $data = $this->getRequestData();
        $updates = [];
        $params = [];

        // Handle username update
        if (isset($data['username'])) {
            $username = $this->sanitizeInput($data['username']);
            $updates[] = "username = ?";
            $params[] = $username;
        }

        // Handle email update
        if (isset($data['email'])) {
            $this->validateEmail($data['email']);
            $email = $this->sanitizeInput($data['email']);
            $updates[] = "email = ?";
            $params[] = $email;
        }

        // Handle password update
        if (isset($data['password'])) {
            $this->validatePassword($data['password']);
            $password = $this->hashPassword($data['password']);
            $updates[] = "password = ?";
            $params[] = $password;
        }

        // Handle role update (admin only)
        if (isset($data['role'])) {
            if (!$this->isAdmin()) {
                $this->sendError('Only admins can update roles', 403);
            }
            $role = $this->sanitizeInput($data['role']);
            if (!in_array($role, ['admin', 'user'])) {
                $this->sendError('Invalid role', 400);
            }
            $updates[] = "role = ?";
            $params[] = $role;
        }

        if (empty($updates)) {
            $this->sendError('No fields to update', 400);
        }

        try {
            // Add ID to params
            $params[] = $id;

            // Update user
            $stmt = $this->db->prepare("
                UPDATE users 
                SET " . implode(", ", $updates) . "
                WHERE id = ?
            ");
            
            $stmt->execute($params);

            if ($stmt->rowCount() === 0) {
                $this->sendError('User not found', 404);
            }

            $this->sendResponse(['message' => 'User updated successfully']);
        } catch (PDOException $e) {
            $this->sendError('Database error: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        // Only admins can delete users
        $this->checkAdminAccess();

        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);

            if ($stmt->rowCount() === 0) {
                $this->sendError('User not found', 404);
            }

            $this->sendResponse(['message' => 'User deleted successfully']);
        } catch (PDOException $e) {
            $this->sendError('Database error: ' . $e->getMessage(), 500);
        }
    }
} 