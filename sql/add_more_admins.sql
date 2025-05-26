-- Add more admin accounts
INSERT INTO users (username, password, email, role) VALUES 
('AdminG', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'adminclaire@example.com', 'admin'),
('AdminB', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'adminjohn@example.com', 'admin'),
('AdminP', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'adminmary@example.com', 'admin'),
('AdminE', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'adminmary@example.com', 'admin')
ON DUPLICATE KEY UPDATE 
password = VALUES(password),
email = VALUES(email),
role = VALUES(role); 