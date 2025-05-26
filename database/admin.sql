USE GALORPOT;

-- Remove any existing admin account
DELETE FROM users WHERE username = 'admin';

-- Create fresh admin account with password '123'
INSERT INTO users (username, password, email, role) 
VALUES ('admin', '123', 'admin@galorpot.com', 'admin'); 