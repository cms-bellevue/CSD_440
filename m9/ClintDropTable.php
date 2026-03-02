<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 8 Programming Assignment
 * Drop Table Script
 * 02/23/2026
 *
 * This program:
 * - Executes a DROP TABLE statement for the game_collection table
 * - Uses a preliminary check to verify table existence before removal
 * - Provides feedback based on whether the operation was successful
 */

require_once __DIR__ . '/ClintDbConfig.php';
$conn = get_db_connection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Drop Collection Table</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Drop Game Collection</h2>
    <?php
    try {
        // Check if the specific gaming table exists before attempting drop
        $checkTable = $conn->query("SHOW TABLES LIKE 'game_collection'");
        if ($checkTable->num_rows > 0) {
            $conn->query("DROP TABLE game_collection");
            echo "<div class='message'>Success: Table 'game_collection' has been removed.</div>";
        } else {
            echo "<div class='message warning-msg'>Notice: No collection table found to drop.</div>";
        }
    } catch (mysqli_sql_exception $e) {
        echo "<div class='message error-msg'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
    ?>
    <a href="index.php" class="btn btn-back">Back to Index</a>
</div>
</body>
</html>