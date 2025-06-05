-- Add missing columns to products table if they don't exist
ALTER TABLE products
ADD COLUMN IF NOT EXISTS category VARCHAR(100) NULL,
ADD COLUMN IF NOT EXISTS brand VARCHAR(100) NULL,
ADD COLUMN IF NOT EXISTS sku VARCHAR(50) NULL,
ADD COLUMN IF NOT EXISTS status ENUM('active', 'inactive', 'discontinued') DEFAULT 'active',
ADD COLUMN IF NOT EXISTS stock_quantity INT DEFAULT 0,
ADD COLUMN IF NOT EXISTS image_url VARCHAR(255) NULL,
ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

-- Add barcode field to products table
ALTER TABLE products
ADD COLUMN barcode VARCHAR(13) UNIQUE AFTER name;

-- Update existing products to have NULL barcode
UPDATE products SET barcode = NULL; 