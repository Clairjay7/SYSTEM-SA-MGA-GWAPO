-- Add deleted_at column to inventory table
ALTER TABLE `inventory`
ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL AFTER `updated_at`;
 
-- Create indexes after adding the column
CREATE INDEX idx_inventory_quantity ON inventory(quantity);
CREATE INDEX idx_inventory_deleted_at ON inventory(deleted_at); 