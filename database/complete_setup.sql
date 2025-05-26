-- Create database if not exists
CREATE DATABASE IF NOT EXISTS GALORPOT;
USE GALORPOT;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create inventory table
CREATE TABLE IF NOT EXISTS inventory (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    image_url TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100),
    customer_phone VARCHAR(20),
    shipping_address TEXT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    status ENUM('Pending', 'Processing', 'Completed', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES inventory(id)
);

-- Create guest_sessions table
CREATE TABLE IF NOT EXISTS guest_sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    session_id VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (password is 'password')
INSERT INTO users (username, password, email, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@example.com', 'admin')
ON DUPLICATE KEY UPDATE role = 'admin';

-- Insert sample Hot Wheels products
INSERT INTO inventory (name, description, price, quantity, image_url) VALUES
('Hot Wheels 1997 FE Lamborghini Countach Yellow', 'A rare Lamborghini Countach model from 1997.', 100.75, 10, 'https://i.ebayimg.com/images/g/VgcAAeSwunZnoqL~/s-l960.webp'),
('Hot Wheels 1999 Ferrari F355 Berlinetta Red', 'A highly detailed Ferrari model from 1999.', 1000.75, 5, 'https://i.ebayimg.com/images/g/iYcAAeSwCPtno9af/s-l960.webp'),
('Hot Wheels 2000 Lamborghini Diablo Blue', 'A collectible Lamborghini Diablo model from 2000.', 555.75, 8, 'https://i.ebayimg.com/images/g/~KUAAOSwnEFfyX5~/s-l500.webp'),
('Hot Wheels 1995 Nissan Skyline GT-R', 'A stunning Nissan Skyline GT-R model from 1995.', 250.50, 15, 'https://i.ebayimg.com/images/g/u8QAAeSwu~Jn25XQ/s-l500.webp'),
('Hot Wheels 2020 Ford Mustang GT', 'A sleek Ford Mustang GT model from 2020.', 450.99, 12, 'https://i.ebayimg.com/images/g/nBEAAOSwjaZn7Ghc/s-l500.webp'),
('Hot Wheels Batmobile', 'The iconic Batmobile model.', 300.00, 20, 'https://i.ebayimg.com/images/g/0~sAAOSwbqBgdmj-/s-l500.webp'),
('Hot Wheels McLaren P1', 'A limited edition McLaren P1 model.', 650.00, 7, 'https://i.ebayimg.com/images/g/2RUAAOSwEdtndLbG/s-l1600.webp'),
('Hot Wheels Porsche 911 Turbo', 'A detailed Porsche 911 Turbo model.', 380.75, 9, 'https://i.ebayimg.com/images/g/Zh8AAeSwYWxn8Mgg/s-l1600.webp'),
('Hot Wheels Toyota Supra A80', 'A collectible Toyota Supra A80 model.', 420.25, 11, 'https://i.ebayimg.com/images/g/p9oAAOSw1LpnxSfv/s-l1600.webp'),
('Hot Wheels 1994 Mazda RX-7', 'A rare Mazda RX-7 model from 1994.', 550.00, 6, 'https://i.ebayimg.com/images/g/pOkAAOSwNQNl-4Ng/s-l1600.webp')
ON DUPLICATE KEY UPDATE quantity = quantity; 