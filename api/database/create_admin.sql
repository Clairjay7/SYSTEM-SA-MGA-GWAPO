-- Insert admin user (password: 123)
INSERT INTO users (username, email, password, role, status)
VALUES (
    'admin',
    'admin@hotwheels.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- hashed password: "123"
    'admin',
    'active'
)
ON DUPLICATE KEY UPDATE
    email = VALUES(email),
    password = VALUES(password),
    role = VALUES(role),
    status = VALUES(status); 