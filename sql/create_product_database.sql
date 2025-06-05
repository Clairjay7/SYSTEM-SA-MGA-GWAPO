-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS GALORPOT;
USE GALORPOT;

-- Create products table FIRST (since other tables reference it)
CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category VARCHAR(100),
    brand VARCHAR(100),
    sku VARCHAR(50) UNIQUE,
    stock_quantity INT NOT NULL DEFAULT 0,
    image_url VARCHAR(255),
    status ENUM('active', 'inactive', 'discontinued') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create indexes for products table
CREATE INDEX idx_products_name ON products(name);
CREATE INDEX idx_products_category ON products(category);
CREATE INDEX idx_products_brand ON products(brand);
CREATE INDEX idx_products_sku ON products(sku);
CREATE INDEX idx_products_status ON products(status);
CREATE INDEX idx_products_price ON products(price);
CREATE INDEX idx_products_stock ON products(stock_quantity);

-- Create product categories table
CREATE TABLE IF NOT EXISTS product_categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create product brands table
CREATE TABLE IF NOT EXISTS product_brands (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create product images table (references products)
CREATE TABLE IF NOT EXISTS product_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    is_primary BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create product inventory history table (references products)
CREATE TABLE IF NOT EXISTS product_inventory_history (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    action ENUM('add', 'remove', 'adjust') NOT NULL,
    quantity INT NOT NULL,
    previous_quantity INT NOT NULL,
    new_quantity INT NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample categories
INSERT INTO product_categories (name, description) VALUES
('Gaming Peripherals', 'Gaming mice, keyboards, headsets, and other accessories'),
('Computer Components', 'CPUs, GPUs, motherboards, and other PC parts'),
('Audio Equipment', 'Headphones, speakers, and audio accessories'),
('Networking', 'Routers, switches, and networking equipment'),
('Storage', 'Hard drives, SSDs, and storage solutions');

-- Insert sample brands
INSERT INTO product_brands (name, description) VALUES
('RazerTech', 'High-end gaming peripherals and accessories'),
('CorsairPro', 'Quality gaming and computer components'),
('SteelSound', 'Premium audio equipment for gaming'),
('LogiTech', 'Reliable computer peripherals and accessories'),
('MSI Gaming', 'Gaming laptops and computer components');

-- Insert sample products
INSERT INTO products (name, description, price, category, brand, sku, stock_quantity, status) VALUES
('Gaming Mouse X1', 'High-DPI gaming mouse with RGB lighting', 59.99, 'Gaming Peripherals', 'RazerTech', 'GM-001-X1', 100, 'active'),
('Mechanical Keyboard Pro', 'RGB mechanical keyboard with blue switches', 129.99, 'Gaming Peripherals', 'CorsairPro', 'KB-002-PRO', 50, 'active'),
('7.1 Gaming Headset', 'Surround sound gaming headset with noise cancellation', 89.99, 'Audio Equipment', 'SteelSound', 'HS-003-71', 75, 'active');

-- Create trigger to update inventory history
DELIMITER //
CREATE TRIGGER after_product_stock_update
AFTER UPDATE ON products
FOR EACH ROW
BEGIN
    IF OLD.stock_quantity != NEW.stock_quantity THEN
        INSERT INTO product_inventory_history 
        (product_id, action, quantity, previous_quantity, new_quantity, notes)
        VALUES 
        (NEW.id, 
         CASE 
            WHEN NEW.stock_quantity > OLD.stock_quantity THEN 'add'
            WHEN NEW.stock_quantity < OLD.stock_quantity THEN 'remove'
            ELSE 'adjust'
         END,
         ABS(NEW.stock_quantity - OLD.stock_quantity),
         OLD.stock_quantity,
         NEW.stock_quantity,
         CONCAT('Stock updated from ', OLD.stock_quantity, ' to ', NEW.stock_quantity)
        );
    END IF;
END//
DELIMITER ;

-- Create view for product stock status
CREATE OR REPLACE VIEW product_stock_status AS
SELECT 
    p.id,
    p.name,
    p.sku,
    p.stock_quantity,
    CASE 
        WHEN p.stock_quantity = 0 THEN 'Out of Stock'
        WHEN p.stock_quantity < 10 THEN 'Low Stock'
        ELSE 'In Stock'
    END as stock_status,
    p.status as product_status,
    p.updated_at as last_updated
FROM products p
WHERE p.deleted_at IS NULL; 