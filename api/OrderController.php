<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../config/Database.php';

class OrderController extends BaseController {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAll() {
        try {
            $user = $this->getCurrentUser();
            
            // Prepare base query
            $query = "
                SELECT o.*, u.username as user_username
                FROM orders o
                LEFT JOIN users u ON o.user_id = u.id
                WHERE o.deleted_at IS NULL
            ";
            
            // If not admin, only show user's orders
            if (!$this->isAdmin()) {
                $query .= " AND o.user_id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$user['id']]);
            } else {
                $stmt = $this->db->prepare($query);
                $stmt->execute();
            }
            
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Get order items for each order
            foreach ($orders as &$order) {
                $stmt = $this->db->prepare("
                    SELECT oi.*, p.name as product_name
                    FROM order_items oi
                    LEFT JOIN products p ON oi.product_id = p.id
                    WHERE oi.order_id = ?
                ");
                $stmt->execute([$order['id']]);
                $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
            $this->sendResponse($orders);
        } catch (Exception $e) {
            $this->sendError('Failed to fetch orders: ' . $e->getMessage(), 500);
        }
    }

    public function getOne($id) {
        try {
            $user = $this->getCurrentUser();
            
            // Prepare query
            $query = "
                SELECT o.*, u.username as user_username
                FROM orders o
                LEFT JOIN users u ON o.user_id = u.id
                WHERE o.id = ? AND o.deleted_at IS NULL
            ";
            
            // If not admin, only allow viewing own orders
            if (!$this->isAdmin()) {
                $query .= " AND o.user_id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$id, $user['id']]);
            } else {
                $stmt = $this->db->prepare($query);
                $stmt->execute([$id]);
            }
            
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$order) {
                $this->sendError('Order not found', 404);
                return;
            }
            
            // Get order items
            $stmt = $this->db->prepare("
                SELECT oi.*, p.name as product_name
                FROM order_items oi
                LEFT JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = ?
            ");
            $stmt->execute([$id]);
            $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $this->sendResponse($order);
        } catch (Exception $e) {
            $this->sendError('Failed to fetch order: ' . $e->getMessage(), 500);
        }
    }

    public function create() {
        try {
            $this->db->beginTransaction();
            
            // Get request data
            $data = $this->getRequestData();
            $user = $this->getCurrentUser();
            
            // Validate required fields
            $this->validateRequired($data, ['products']);
            
            if (!is_array($data['products']) || empty($data['products'])) {
                $this->sendError('Products array is required and cannot be empty', 400);
                return;
            }
            
            // Calculate total amount and validate products
            $total_amount = 0;
            foreach ($data['products'] as $item) {
                if (!isset($item['product_id']) || !isset($item['quantity'])) {
                    $this->sendError('Each product must have product_id and quantity', 400);
                    return;
                }
                
                // Check product exists and has enough stock
                $stmt = $this->db->prepare("
                    SELECT id, price, stock 
                    FROM products 
                    WHERE id = ? AND deleted_at IS NULL
                ");
                $stmt->execute([$item['product_id']]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$product) {
                    $this->sendError('Product not found: ' . $item['product_id'], 404);
                    return;
                }
                
                if ($product['stock'] < $item['quantity']) {
                    $this->sendError('Insufficient stock for product: ' . $item['product_id'], 400);
                    return;
                }
                
                $total_amount += $product['price'] * $item['quantity'];
            }
            
            // Create order
            $stmt = $this->db->prepare("
                INSERT INTO orders (user_id, total_amount, status, created_at, updated_at)
                VALUES (?, ?, 'pending', NOW(), NOW())
            ");
            $stmt->execute([$user['id'], $total_amount]);
            
            $orderId = $this->db->lastInsertId();
            
            // Create order items and update stock
            foreach ($data['products'] as $item) {
                // Add order item
                $stmt = $this->db->prepare("
                    INSERT INTO order_items (order_id, product_id, quantity, price)
                    SELECT ?, ?, ?, price
                    FROM products
                    WHERE id = ?
                ");
                $stmt->execute([$orderId, $item['product_id'], $item['quantity'], $item['product_id']]);
                
                // Update stock
                $stmt = $this->db->prepare("
                    UPDATE products
                    SET stock = stock - ?, updated_at = NOW()
                    WHERE id = ?
                ");
                $stmt->execute([$item['quantity'], $item['product_id']]);
            }
            
            $this->db->commit();
            
            // Fetch created order
            $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
            $stmt->execute([$orderId]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->sendResponse($order, 'Order created successfully', 201);
        } catch (Exception $e) {
            $this->db->rollBack();
            $this->sendError('Failed to create order: ' . $e->getMessage(), 500);
        }
    }

    public function update($id) {
        try {
            // Get request data
            $data = $this->getRequestData();
            $user = $this->getCurrentUser();
            
            // Check if order exists and user has access
            $query = "SELECT * FROM orders WHERE id = ? AND deleted_at IS NULL";
            if (!$this->isAdmin()) {
                $query .= " AND user_id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$id, $user['id']]);
            } else {
                $stmt = $this->db->prepare($query);
                $stmt->execute([$id]);
            }
            
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$order) {
                $this->sendError('Order not found', 404);
                return;
            }
            
            // Only allow updating status
            if (isset($data['status'])) {
                $stmt = $this->db->prepare("
                    UPDATE orders 
                    SET status = ?, updated_at = NOW()
                    WHERE id = ?
                ");
                $stmt->execute([$data['status'], $id]);
            }
            
            // Fetch updated order
            $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
            $stmt->execute([$id]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->sendResponse($order, 'Order updated successfully');
        } catch (Exception $e) {
            $this->sendError('Failed to update order: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        try {
            $user = $this->getCurrentUser();
            
            // Check if order exists and user has access
            $query = "SELECT * FROM orders WHERE id = ? AND deleted_at IS NULL";
            if (!$this->isAdmin()) {
                $query .= " AND user_id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$id, $user['id']]);
            } else {
                $stmt = $this->db->prepare($query);
                $stmt->execute([$id]);
            }
            
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$order) {
                $this->sendError('Order not found', 404);
                return;
            }
            
            // Soft delete the order
            $stmt = $this->db->prepare("
                UPDATE orders 
                SET deleted_at = NOW(), updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([$id]);
            
            $this->sendResponse(null, 'Order deleted successfully');
        } catch (Exception $e) {
            $this->sendError('Failed to delete order: ' . $e->getMessage(), 500);
        }
    }

    public function createOrder() {
        try {
            // Get request data
            $data = json_decode(file_get_contents("php://input"));
            
            if (!$this->validateOrderData($data)) {
                throw new Exception("Invalid order data");
            }

            // Start transaction
            $this->db->beginTransaction();

            // Acquire lock for inventory updates
            $lockName = "inventory_lock_" . $data->product_id;
            if (!$this->db->acquireLock($lockName)) {
                throw new Exception("Could not acquire lock for inventory");
            }

            try {
                // Check inventory availability
                $stmt = $this->conn->prepare("
                    SELECT quantity FROM inventory 
                    WHERE id = ? AND quantity >= ? 
                    FOR UPDATE
                ");
                $stmt->execute([$data->product_id, $data->quantity]);
                
                if ($stmt->rowCount() === 0) {
                    throw new Exception("Insufficient inventory");
                }

                // Create order
                $stmt = $this->conn->prepare("
                    INSERT INTO orders (
                        product_id, customer_name, customer_email,
                        customer_phone, shipping_address, quantity,
                        price, payment_method, status
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')
                ");
                
                $stmt->execute([
                    $data->product_id,
                    $data->customer_name,
                    $data->customer_email,
                    $data->customer_phone,
                    $data->shipping_address,
                    $data->quantity,
                    $data->price,
                    $data->payment_method
                ]);
                
                $orderId = $this->conn->lastInsertId();

                // Update inventory
                $stmt = $this->conn->prepare("
                    UPDATE inventory 
                    SET quantity = quantity - ?
                    WHERE id = ?
                ");
                $stmt->execute([$data->quantity, $data->product_id]);

                // Create inventory movement record
                $stmt = $this->conn->prepare("
                    INSERT INTO inventory_movements (
                        product_id, quantity, type,
                        reference_id, reference_type
                    ) VALUES (?, ?, 'out', ?, 'order')
                ");
                $stmt->execute([
                    $data->product_id,
                    $data->quantity,
                    $orderId
                ]);

                // Create transaction log
                $stmt = $this->conn->prepare("
                    INSERT INTO transaction_logs (
                        order_id, type, amount, status
                    ) VALUES (?, 'purchase', ?, 'pending')
                ");
                $stmt->execute([
                    $orderId,
                    $data->price * $data->quantity
                ]);

                // Commit transaction
                $this->db->commit();

                // Release lock
                $this->db->releaseLock($lockName);

                http_response_code(201);
                echo json_encode([
                    "status" => "success",
                    "message" => "Order created successfully",
                    "order_id" => $orderId
                ]);

            } catch (Exception $e) {
                $this->db->rollback();
                $this->db->releaseLock($lockName);
                throw $e;
            }

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function processRefund() {
        try {
            $data = json_decode(file_get_contents("php://input"));
            
            if (!isset($data->order_id) || !isset($data->reason)) {
                throw new Exception("Missing required refund data");
            }

            $this->db->beginTransaction();

            // Acquire lock for order processing
            $lockName = "order_lock_" . $data->order_id;
            if (!$this->db->acquireLock($lockName)) {
                throw new Exception("Could not acquire lock for order");
            }

            try {
                // Check if order exists and is completed
                $stmt = $this->conn->prepare("
                    SELECT o.*, i.id as product_id
                    FROM orders o
                    JOIN inventory i ON o.product_id = i.id
                    WHERE o.id = ? AND o.status = 'Completed'
                    FOR UPDATE
                ");
                $stmt->execute([$data->order_id]);
                $order = $stmt->fetch();

                if (!$order) {
                    throw new Exception("Order not found or not eligible for refund");
                }

                // Create refund record
                $stmt = $this->conn->prepare("
                    INSERT INTO refunds (
                        order_id, amount, reason, status
                    ) VALUES (?, ?, ?, 'pending')
                ");
                $stmt->execute([
                    $data->order_id,
                    $order['price'] * $order['quantity'],
                    $data->reason
                ]);
                
                $refundId = $this->conn->lastInsertId();

                // Update inventory
                $stmt = $this->conn->prepare("
                    UPDATE inventory 
                    SET quantity = quantity + ?
                    WHERE id = ?
                ");
                $stmt->execute([$order['quantity'], $order['product_id']]);

                // Create inventory movement record
                $stmt = $this->conn->prepare("
                    INSERT INTO inventory_movements (
                        product_id, quantity, type,
                        reference_id, reference_type
                    ) VALUES (?, ?, 'in', ?, 'refund')
                ");
                $stmt->execute([
                    $order['product_id'],
                    $order['quantity'],
                    $refundId
                ]);

                // Create transaction log
                $stmt = $this->conn->prepare("
                    INSERT INTO transaction_logs (
                        order_id, type, amount, status
                    ) VALUES (?, 'refund', ?, 'pending')
                ");
                $stmt->execute([
                    $data->order_id,
                    $order['price'] * $order['quantity']
                ]);

                // Commit transaction
                $this->db->commit();

                // Release lock
                $this->db->releaseLock($lockName);

                http_response_code(200);
                echo json_encode([
                    "status" => "success",
                    "message" => "Refund processed successfully",
                    "refund_id" => $refundId
                ]);

            } catch (Exception $e) {
                $this->db->rollback();
                $this->db->releaseLock($lockName);
                throw $e;
            }

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    private function validateOrderData($data) {
        return (
            isset($data->product_id) &&
            isset($data->customer_name) &&
            isset($data->quantity) &&
            isset($data->price) &&
            isset($data->payment_method) &&
            $data->quantity > 0 &&
            $data->price > 0
        );
    }
} 