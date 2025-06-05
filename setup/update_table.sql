-- Create password_history table
CREATE TABLE IF NOT EXISTS password_history (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Add indexes for better performance
CREATE INDEX idx_user_passwords ON password_history(user_id, password_hash);

-- Add category column to inventory table
ALTER TABLE inventory ADD COLUMN category ENUM('Regular', 'Premium', 'Limited Edition') DEFAULT 'Regular';

-- Update existing products to have categories
UPDATE inventory SET category = 'Regular' WHERE category IS NULL;

-- Add customer_name to orders table
ALTER TABLE orders ADD COLUMN customer_name VARCHAR(100) DEFAULT NULL; 