-- Create indexes for better performance
-- Only create if they don't exist
SELECT IF(
    NOT EXISTS(
        SELECT 1 FROM information_schema.statistics 
        WHERE table_schema = DATABASE()
        AND table_name = 'inventory'
        AND index_name = 'idx_inventory_quantity'
    ),
    'CREATE INDEX idx_inventory_quantity ON inventory(quantity)',
    'SELECT ''Index idx_inventory_quantity already exists'''
) INTO @sql;
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SELECT IF(
    NOT EXISTS(
        SELECT 1 FROM information_schema.statistics 
        WHERE table_schema = DATABASE()
        AND table_name = 'inventory'
        AND index_name = 'idx_inventory_deleted_at'
    ),
    'CREATE INDEX idx_inventory_deleted_at ON inventory(deleted_at)',
    'SELECT ''Index idx_inventory_deleted_at already exists'''
) INTO @sql;
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt; 