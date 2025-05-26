USE GALORPOT;

-- Drop existing guest_sessions table if it exists
DROP TABLE IF EXISTS guest_sessions;

-- Create guest_sessions table with more tracking information
CREATE TABLE guest_sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    session_id VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 