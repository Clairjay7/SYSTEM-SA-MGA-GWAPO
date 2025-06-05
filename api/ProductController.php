<?php
require_once __DIR__ . '/../core/BaseController.php';

class ProductController extends BaseController {
    public function getAll() {
        try {
            $stmt = $this->db->prepare("
                SELECT id, name, description, price, stock, created_at, updated_at 
                FROM products 
                WHERE deleted_at IS NULL
            ");
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $this->sendResponse($products);
        } catch (Exception $e) {
            $this->sendError('Failed to fetch products: ' . $e->getMessage(), 500);
        }
    }

    public function getOne($id) {
        try {
            $stmt = $this->db->prepare("
                SELECT id, name, description, price, stock, created_at, updated_at 
                FROM products 
                WHERE id = ? AND deleted_at IS NULL
            ");
            $stmt->execute([$id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$product) {
                $this->sendError('Product not found', 404);
                return;
            }
            
            $this->sendResponse($product);
        } catch (Exception $e) {
            $this->sendError('Failed to fetch product: ' . $e->getMessage(), 500);
        }
    }

    public function create() {
        try {
            // Check admin access
            $this->checkAdminAccess();
            
            // Get request data
            $data = $this->getRequestData();
            
            // Validate required fields
            $this->validateRequired($data, ['name', 'price']);
            
            // Sanitize input
            $name = $this->sanitizeInput($data['name']);
            $description = $this->sanitizeInput($data['description'] ?? '');
            $price = floatval($data['price']);
            $stock = intval($data['stock'] ?? 0);
            
            // Insert product
            $stmt = $this->db->prepare("
                INSERT INTO products (name, description, price, stock, created_at, updated_at) 
                VALUES (?, ?, ?, ?, NOW(), NOW())
            ");
            $stmt->execute([$name, $description, $price, $stock]);
            
            $productId = $this->db->lastInsertId();
            
            // Fetch the created product
            $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->sendResponse($product, 'Product created successfully', 201);
        } catch (Exception $e) {
            $this->sendError('Failed to create product: ' . $e->getMessage(), 500);
        }
    }

    public function update($id) {
        try {
            // Check admin access
            $this->checkAdminAccess();
            
            // Get request data
            $data = $this->getRequestData();
            
            // Check if product exists
            $stmt = $this->db->prepare("SELECT id FROM products WHERE id = ? AND deleted_at IS NULL");
            $stmt->execute([$id]);
            if (!$stmt->fetch()) {
                $this->sendError('Product not found', 404);
                return;
            }
            
            // Build update query
            $updates = [];
            $params = [];
            
            if (isset($data['name'])) {
                $updates[] = "name = ?";
                $params[] = $this->sanitizeInput($data['name']);
            }
            if (isset($data['description'])) {
                $updates[] = "description = ?";
                $params[] = $this->sanitizeInput($data['description']);
            }
            if (isset($data['price'])) {
                $updates[] = "price = ?";
                $params[] = floatval($data['price']);
            }
            if (isset($data['stock'])) {
                $updates[] = "stock = ?";
                $params[] = intval($data['stock']);
            }
            
            if (empty($updates)) {
                $this->sendError('No fields to update', 400);
                return;
            }
            
            $updates[] = "updated_at = NOW()";
            $params[] = $id;
            
            // Update product
            $stmt = $this->db->prepare("
                UPDATE products 
                SET " . implode(", ", $updates) . "
                WHERE id = ?
            ");
            $stmt->execute($params);
            
            // Fetch updated product
            $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->sendResponse($product, 'Product updated successfully');
        } catch (Exception $e) {
            $this->sendError('Failed to update product: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        try {
            // Check admin access
            $this->checkAdminAccess();
            
            // Check if product exists
            $stmt = $this->db->prepare("SELECT id FROM products WHERE id = ? AND deleted_at IS NULL");
            $stmt->execute([$id]);
            if (!$stmt->fetch()) {
                $this->sendError('Product not found', 404);
                return;
            }
            
            // Soft delete the product
            $stmt = $this->db->prepare("UPDATE products SET deleted_at = NOW() WHERE id = ?");
            $stmt->execute([$id]);
            
            $this->sendResponse(null, 'Product deleted successfully');
        } catch (Exception $e) {
            $this->sendError('Failed to delete product: ' . $e->getMessage(), 500);
        }
    }
} 