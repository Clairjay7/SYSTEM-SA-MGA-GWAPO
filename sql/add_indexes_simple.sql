-- Just try to create the indexes
-- If they already exist, the error can be ignored
CREATE INDEX idx_inventory_quantity ON inventory(quantity);
CREATE INDEX idx_inventory_deleted_at ON inventory(deleted_at); 