-- Indexes for inventory table
CREATE INDEX idx_inventory_quantity ON inventory(quantity);
CREATE INDEX idx_inventory_deleted_at ON inventory(deleted_at);

-- Indexes for inventory movements table
CREATE INDEX idx_movements_product ON inventory_movements(product_id);
CREATE INDEX idx_movements_reference ON inventory_movements(reference_type, reference_id);

-- Indexes for inventory alerts table
CREATE INDEX idx_alerts_status ON inventory_alerts(status);

-- Indexes for inventory logs table
CREATE INDEX idx_logs_action ON inventory_logs(action);
CREATE INDEX idx_logs_timestamp ON inventory_logs(timestamp); 