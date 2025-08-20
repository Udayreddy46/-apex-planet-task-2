-- Black Box Task 2 - Blog Database Schema
-- PHP & MySQL CRUD Application with Authentication

-- Create database
CREATE DATABASE IF NOT EXISTS blog;
USE blog;

-- Users table for authentication
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Posts table for blog content
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Sample data for testing
-- Insert sample users (passwords are hashed)
INSERT INTO users (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- password: password
('user1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); -- password: password

-- Insert sample posts
INSERT INTO posts (user_id, title, content) VALUES 
(1, 'Welcome to My Blog', 'This is the first post on my blog. Excited to share my thoughts and experiences!'),
(1, 'PHP CRUD Tutorial', 'Learn how to create a complete CRUD application with PHP and MySQL.'),
(2, 'My First Post', 'Hello everyone! This is my first post on this amazing blog platform.');
