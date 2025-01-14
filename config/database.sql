CREATE DATABASE imbs_campus;
USE imbs_campus;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nic VARCHAR(12) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    telephone VARCHAR(15) NOT NULL,
    course VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);