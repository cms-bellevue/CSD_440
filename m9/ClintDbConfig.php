<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 8 Programming Assignment
 * Secure Database Configuration
 * 02/22/2026
 *
 * This program:
 * - Stores database credentials for the retro_admin account
 * - Enables strict mysqli error reporting for try-catch support
 * - Provides a secure, reusable static connection function
 * - Implements server-side error logging for connection failures
 */

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

define('DB_HOST', 'localhost');
define('DB_USER', 'retro_admin');
define('DB_PASS', 'Keen1990!');
define('DB_NAME', 'retro_gaming_db');

function get_db_connection() {
    static $conn = null;
    if ($conn === null) {
        try {
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $conn->set_charset("utf8mb4");
        } catch (mysqli_sql_exception $e) {
            error_log($e->getMessage());
            die("A database connection error occurred. Please try again later.");
        }
    }
    return $conn;
}
?>