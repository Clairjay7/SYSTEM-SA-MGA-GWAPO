-- Create inventory table with enhanced fields
CREATE TABLE IF NOT EXISTS inventory (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

-- Create inventory movements table for tracking stock changes
CREATE TABLE IF NOT EXISTS inventory_movements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    type ENUM('in', 'out') NOT NULL,
    reference_type VARCHAR(50),
    reference_id VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES inventory(id)
);

-- Create inventory alerts table
CREATE TABLE IF NOT EXISTS inventory_alerts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    item_id INT NOT NULL,
    alert_type ENUM('low_stock', 'out_of_stock') NOT NULL,
    status ENUM('active', 'resolved') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    resolved_at TIMESTAMP NULL,
    FOREIGN KEY (item_id) REFERENCES inventory(id),
    UNIQUE KEY unique_active_alert (item_id, alert_type, status)
);

-- Create inventory logs table for error tracking and monitoring
CREATE TABLE IF NOT EXISTS inventory_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    action VARCHAR(50) NOT NULL,
    details JSON,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create indexes for better performance
CREATE INDEX idx_inventory_quantity ON inventory(quantity);
CREATE INDEX idx_inventory_deleted_at ON inventory(deleted_at);
CREATE INDEX idx_movements_product ON inventory_movements(product_id);
CREATE INDEX idx_movements_reference ON inventory_movements(reference_type, reference_id);
CREATE INDEX idx_alerts_status ON inventory_alerts(status);
CREATE INDEX idx_logs_action ON inventory_logs(action);
CREATE INDEX idx_logs_timestamp ON inventory_logs(timestamp); 