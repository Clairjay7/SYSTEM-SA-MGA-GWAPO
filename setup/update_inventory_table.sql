-- Add barcode field to inventory table
ALTER TABLE inventory
ADD COLUMN barcode VARCHAR(13) UNIQUE AFTER name;

-- Update existing inventory items to have NULL barcode
UPDATE inventory SET barcode = NULL; 