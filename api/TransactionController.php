<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../utils/Response.php';

class TransactionController extends BaseController {
    private $transaction;
    private $response;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->transaction = new Transaction($db);
        $this->response = new Response();
    }
    
    /**
     * Create a new order with transaction handling
     */
    public function createOrder() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['items']) || empty($data['items'])) {
                return $this->response->error('No items provided', 400);
            }

            $result = $this->transaction->execute(function() use ($data) {
                $totalAmount = 0;
                $orderItems = [];

                // Lock and validate all products first
                foreach ($data['items'] as $item) {
                    $product = $this->transaction->lockProduct($item['product_id']);
                    
                    if (!$product) {
                        throw new Exception("Product not found: {$item['product_id']}");
                    }
                    
                    if ($product['stock'] < $item['quantity']) {
                        throw new Exception("Insufficient stock for product: {$item['product_id']}");
                    }

                    $itemTotal = $product['price'] * $item['quantity'];
                    $totalAmount += $itemTotal;
                    
                    $orderItems[] = [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'price' => $product['price'],
                        'version' => $product['version']
                    ];
                }

                // Create order
                $stmt = $this->db->prepare(
                    "INSERT INTO orders (user_id, total_amount, status) 
                     VALUES (?, ?, 'pending')"
                );
                $stmt->execute([$_SESSION['user_id'], $totalAmount]);
                $orderId = $this->db->lastInsertId();

                // Create order items and update stock
                foreach ($orderItems as $item) {
                    // Create order item
                    $stmt = $this->db->prepare(
                        "INSERT INTO order_items (order_id, product_id, quantity, price) 
                         VALUES (?, ?, ?, ?)"
                    );
                    $stmt->execute([
                        $orderId,
                        $item['product']['id'],
                        $item['quantity'],
                        $item['price']
                    ]);

                    // Update product stock with optimistic locking
                    $this->transaction->updateProductStock(
                        $item['product']['id'],
                        $item['quantity'],
                        $item['version']
                    );

                    // Record inventory movement
                    $this->transaction->recordInventoryMovement(
                        $item['product']['id'],
                        $item['quantity'],
                        'out',
                        $orderId,
                        'order'
                    );
                }

                // Log transaction
                $this->transaction->logTransaction(
                    $orderId,
                    'purchase',
                    $totalAmount,
                    'completed'
                );

                return [
                    'order_id' => $orderId,
                    'total_amount' => $totalAmount,
                    'items' => count($orderItems)
                ];
            });

            return $this->response->success($result);
        } catch (Exception $e) {
            return $this->response->error($e->getMessage(), 400);
        }
    }
    
    /**
     * Process a refund request
     */
    public function processRefund($orderId) {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['reason'])) {
                return $this->response->error('Refund reason is required', 400);
            }

            $result = $this->transaction->execute(function() use ($orderId, $data) {
                // Get order details
                $stmt = $this->db->prepare(
                    "SELECT * FROM orders WHERE id = ? AND status = 'completed'"
                );
                $stmt->execute([$orderId]);
                $order = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$order) {
                    throw new Exception('Order not found or not eligible for refund');
                }

                // Create refund record
                $refundId = $this->transaction->createRefund(
                    $orderId,
                    $order['total_amount'],
                    $data['reason']
                );

                // Get order items
                $stmt = $this->db->prepare(
                    "SELECT * FROM order_items WHERE order_id = ?"
                );
                $stmt->execute([$orderId]);
                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Return items to inventory
                foreach ($items as $item) {
                    $product = $this->transaction->lockProduct($item['product_id']);
                    
                    // Update stock
                    $stmt = $this->db->prepare(
                        "UPDATE products 
                         SET stock = stock + ?, 
                             version = version + 1 
                         WHERE id = ?"
                    );
                    $stmt->execute([$item['quantity'], $item['product_id']]);

                    // Record inventory movement
                    $this->transaction->recordInventoryMovement(
                        $item['product_id'],
                        $item['quantity'],
                        'in',
                        $refundId,
                        'refund'
                    );
                }

                // Update order status
                $stmt = $this->db->prepare(
                    "UPDATE orders SET status = 'cancelled' WHERE id = ?"
                );
                $stmt->execute([$orderId]);

                // Log refund transaction
                $this->transaction->logTransaction(
                    $orderId,
                    'refund',
                    $order['total_amount'],
                    'completed'
                );

                return [
                    'refund_id' => $refundId,
                    'order_id' => $orderId,
                    'amount' => $order['total_amount'],
                    'status' => 'completed'
                ];
            });

            return $this->response->success($result);
        } catch (Exception $e) {
            return $this->response->error($e->getMessage(), 400);
        }
    }

    /**
     * Get transaction history
     */
    public function getTransactionHistory($orderId = null) {
        try {
            if ($orderId) {
                $history = $this->transaction->getTransactionHistory($orderId);
            } else {
                // Get all transactions for user
                $stmt = $this->db->prepare(
                    "SELECT t.*, o.user_id 
                     FROM transaction_logs t
                     JOIN orders o ON t.order_id = o.id
                     WHERE o.user_id = ?
                     ORDER BY t.created_at DESC"
                );
                $stmt->execute([$_SESSION['user_id']]);
                $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return $this->response->success(['transactions' => $history]);
        } catch (Exception $e) {
            return $this->response->error($e->getMessage(), 400);
        }
    }
} 