USE galorpot;

-- First, clear any existing users to ensure clean setup
DELETE FROM users WHERE username = 'admin';

-- Insert admin user with password '123'
INSERT INTO users (username, password, email, role) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@galorpot.com', 'admin'); 