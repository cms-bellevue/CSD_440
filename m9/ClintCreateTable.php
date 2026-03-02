<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 8 Programming Assignment
 * Create Table Script
 * 02/23/2026
 *
 * This program:
 * - Includes database configuration via absolute path
 * - Verifies if the game_collection table already exists
 * - Defines schema for retro titles, platforms, and completion status
 * - Provides specific feedback based on the action taken
 */

require_once __DIR__ . '/ClintDbConfig.php';
$conn = get_db_connection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game Table Creation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Game Collection Initialization</h2>
    <?php
    try {
        $checkTable = $conn->query("SHOW TABLES LIKE 'game_collection'");
        if ($checkTable->num_rows > 0) {
            echo "<div class='message warning-msg'>Notice: Table 'game_collection' already exists.</div>";
        } else {
            $sql = "CREATE TABLE game_collection (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(100) NOT NULL,
                platform VARCHAR(50) NOT NULL,
                release_year INT(4) NOT NULL,
                genre VARCHAR(30) NOT NULL,
                is_completed TINYINT(1) DEFAULT 0,
                INDEX (title)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            $conn->query($sql);
            echo "<div class='message'>Success: Table 'game_collection' created.</div>";
        }
    } catch (mysqli_sql_exception $e) {
        echo "<div class='message error-msg'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
    ?>
    <a href="index.php" class="btn btn-back">Back to Index</a>
</div>
</body>
</html>