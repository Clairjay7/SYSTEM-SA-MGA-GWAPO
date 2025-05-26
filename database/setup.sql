-- Drop database if exists and create new one
DROP DATABASE IF EXISTS GALORPOT;
CREATE DATABASE GALORPOT;
USE GALORPOT;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert admin user with password '123'
INSERT INTO users (username, password, email, role) 
VALUES ('admin', '123', 'admin@galorpot.com', 'admin');

-- Create inventory table
CREATE TABLE IF NOT EXISTS inventory (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    image_url VARCHAR(255),
    category VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample products
INSERT INTO inventory (name, description, price, quantity, category) VALUES
('Gaming Mouse', 'High-performance gaming mouse with RGB lighting', 1999.99, 15, 'Gaming'),
('Mechanical Keyboard', 'RGB mechanical keyboard with blue switches', 2499.99, 10, 'Gaming'),
('Gaming Headset', 'Surround sound gaming headset', 1499.99, 20, 'Gaming');

-- Create orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    customer_name VARCHAR(100),
    customer_email VARCHAR(100),
    customer_phone VARCHAR(20),
    shipping_address TEXT,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Create order_items table
CREATE TABLE IF NOT EXISTS order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price_per_unit DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES inventory(id) ON DELETE RESTRICT
);

-- Insert sample orders
INSERT INTO orders (user_id, customer_name, customer_email, customer_phone, shipping_address, total_amount, status) VALUES
(1, 'John Doe', 'john@example.com', '1234567890', '123 Main St, City', 4499.98, 'pending'),
(1, 'Jane Smith', 'jane@example.com', '0987654321', '456 Oak St, Town', 1499.99, 'completed');

-- Insert sample order items
INSERT INTO order_items (order_id, product_id, quantity, price_per_unit) VALUES
(1, 1, 1, 1999.99),
(1, 2, 1, 2499.99),
(2, 3, 1, 1499.99);

-- Create guest_sessions table
CREATE TABLE IF NOT EXISTS guest_sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    session_id VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); 