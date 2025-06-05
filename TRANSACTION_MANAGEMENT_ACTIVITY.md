# Transaction Management and Database Design Activity

## Overview
In this activity, you will enhance the existing `galorpot` database and API system by implementing robust transaction handling, proper database design, and concurrent operation management. The focus is on ensuring data integrity while handling complex operations like orders, refunds, and inventory management.

## Database Enhancement Tasks (30 points)

### 1. Extended Schema Design
Add the following tables to the existing database:

```sql
-- Transaction logs table
CREATE TABLE transaction_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    type ENUM('purchase', 'refund', 'adjustment') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'completed', 'failed', 'reversed') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

-- Inventory movements table
CREATE TABLE inventory_movements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    type ENUM('in', 'out', 'adjustment') NOT NULL,
    reference_id INT,
    reference_type ENUM('order', 'refund', 'manual') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Refunds table
CREATE TABLE refunds (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    reason TEXT NOT NULL,
    status ENUM('pending', 'approved', 'rejected', 'completed') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);
```

### 2. Add Indexes for Performance (10 points)
- Create appropriate indexes for foreign keys
- Add composite indexes for frequently queried columns
- Implement indexes for sorting and filtering operations

## API Implementation Tasks (40 points)

### 1. Order Processing Endpoints

#### Create Order with Transaction
- Endpoint: `POST /api/orders/create`
- Implements proper transaction handling
- Checks inventory availability
- Updates product stock
- Creates transaction log
```php
BEGIN TRANSACTION;
try {
    // 1. Check product availability
    // 2. Create order record
    // 3. Create order items
    // 4. Update product inventory
    // 5. Create transaction log
    COMMIT;
} catch (Exception $e) {
    ROLLBACK;
    // Handle error
}
```

#### Process Refund
- Endpoint: `POST /api/orders/{id}/refund`
- Handles refund requests
- Updates inventory if needed
- Creates refund records
```php
BEGIN TRANSACTION;
try {
    // 1. Validate refund eligibility
    // 2. Create refund record
    // 3. Update order status
    // 4. Adjust inventory if needed
    // 5. Create transaction log
    COMMIT;
} catch (Exception $e) {
    ROLLBACK;
    // Handle error
}
```

### 2. Inventory Management Endpoints

#### Update Inventory
- Endpoint: `PUT /api/products/{id}/inventory`
- Handles stock updates
- Creates movement records
- Implements optimistic locking

#### View Transaction History
- Endpoint: `GET /api/transactions`
- Lists all transactions with filtering
- Includes related order/refund details

## Concurrency Handling Tasks (20 points)

### 1. Implement Row-Level Locking
```php
// Example of handling concurrent inventory updates
SELECT * FROM products WHERE id = ? FOR UPDATE;
```

### 2. Add Version Control for Optimistic Locking
```sql
ALTER TABLE products ADD COLUMN version INT DEFAULT 1;
```

### 3. Handle Race Conditions
- Implement retry logic for concurrent operations
- Add deadlock detection and prevention
- Use proper isolation levels

## Testing Requirements

### 1. Transaction Testing
- Test successful order creation
- Test failed transactions (rollback)
- Verify inventory consistency
- Check transaction logs

### 2. Concurrency Testing
- Test multiple simultaneous orders
- Verify stock levels remain consistent
- Test optimistic locking scenarios

### 3. Performance Testing
- Measure response times under load
- Test index effectiveness
- Monitor lock contention

## Implementation Guidelines

### 1. Database Operations
```php
// Example of transaction handling
public function createOrder($data) {
    $this->db->beginTransaction();
    try {
        // Perform operations
        $this->db->commit();
    } catch (Exception $e) {
        $this->db->rollback();
        throw $e;
    }
}
```

### 2. Concurrency Control
```php
// Example of optimistic locking
public function updateStock($productId, $quantity, $version) {
    $result = $this->db->query(
        "UPDATE products 
         SET stock = stock - ?, version = version + 1 
         WHERE id = ? AND version = ?",
        [$quantity, $productId, $version]
    );
    if ($result->rowCount() === 0) {
        throw new ConcurrencyException();
    }
}
```

## Evaluation Criteria
1. Proper transaction handling and rollback implementation
2. Effective concurrency control mechanisms
3. Database design and indexing strategy
4. Error handling and logging
5. API endpoint implementation and documentation
6. Code organization and clarity

## Submission Requirements
1. Complete SQL schema with indexes
2. API endpoint implementations
3. Transaction handling code
4. Concurrency control implementation
5. Test cases and results
6. Performance testing results

## Notes
- Use appropriate isolation levels for transactions
- Implement proper error handling and logging
- Consider using database triggers for audit trails
- Document all assumptions and design decisions
- Include performance optimization strategies 