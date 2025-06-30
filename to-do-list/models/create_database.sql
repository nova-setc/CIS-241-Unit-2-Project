-- Drop and create the todo_app database
DROP DATABASE IF EXISTS todo_app;
CREATE DATABASE todo_app;
USE todo_app;

-- Drop users table if it exists
DROP TABLE IF EXISTS users;

-- Create users table
CREATE TABLE users (
    user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Drop tasks table if it exists (for repeatable dev imports)
DROP TABLE IF EXISTS tasks;

-- Create tasks table
CREATE TABLE tasks (
    task_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    due_date DATE,
    completed TINYINT(1) NOT NULL DEFAULT 0,
    date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Optional: Create a non-root MySQL user for development
DROP USER IF EXISTS 'todo_admin'@'localhost';
CREATE USER 'todo_admin'@'localhost' IDENTIFIED BY 'todo_password';
GRANT ALL PRIVILEGES ON todo_app.* TO 'todo_admin'@'localhost';
FLUSH PRIVILEGES;

