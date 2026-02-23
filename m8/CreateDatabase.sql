/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 8 Programming Assignment
 * Database Schema and User Creation
 * 02/23/2026
 */

CREATE DATABASE IF NOT EXISTS retro_gaming_db;

CREATE USER IF NOT EXISTS 'retro_admin'@'localhost' IDENTIFIED BY 'Keen1990!';
GRANT ALL PRIVILEGES ON retro_gaming_db.* TO 'retro_admin'@'localhost';
FLUSH PRIVILEGES;

USE retro_gaming_db;

CREATE TABLE IF NOT EXISTS game_collection (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    platform VARCHAR(50) NOT NULL,
    release_year INT(4) NOT NULL,
    genre VARCHAR(30) NOT NULL,
    is_completed TINYINT(1) DEFAULT 0,
    INDEX (title)
) ENGINE=InnoDB;