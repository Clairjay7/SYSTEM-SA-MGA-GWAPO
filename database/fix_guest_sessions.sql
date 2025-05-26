USE GALORPOT;

-- Drop the existing guest_sessions table
DROP TABLE IF EXISTS guest_sessions;

-- Recreate guest_sessions table without UNIQUE constraint
CREATE TABLE guest_sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    session_id VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); 