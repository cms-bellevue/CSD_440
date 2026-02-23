<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 8 Programming Assignment
 * Populate Table Script
 * 02/23/2026
 *
 * This program:
 * - Uses prepared statements to safely insert 10 retro gaming records
 * - Includes PC (MS-DOS), Atari 2600, Commodore 64, and NES titles
 * - Maintains Wolfenstein 3D as the incomplete/inactive record
 * - Prevents SQL injection via mysqli bind_param
 */

require_once __DIR__ . '/ClintDbConfig.php';
$conn = get_db_connection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Populate Collection</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Update Game Library</h2>
    <?php
    try {
        $checkTable = $conn->query("SHOW TABLES LIKE 'game_collection'");
        if ($checkTable->num_rows > 0) {
            $games = [
                ['Commander Keen: Marooned on Mars', 'PC (MS-DOS)', 1990, 'Platformer', 1],
                ['Pitfall!', 'Atari 2600', 1982, 'Platformer', 0],
                ['Yars\' Revenge', 'Atari 2600', 1982, 'Shooter', 1],
                ['Maniac Mansion', 'Commodore 64', 1987, 'Adventure', 0],
                ['Super Mario Bros.', 'NES', 1985, 'Platformer', 1],
                ['Dragon Warrior', 'NES', 1986, 'RPG', 1],
                ['Pac-Man', 'Atari 2600', 1982, 'Maze', 1],
                ['The Bard\'s Tale', 'Commodore 64', 1985, 'RPG', 1],
                ['Oregon Trail', 'PC (MS-DOS)', 1985, 'Educational', 0],
                ['Wolfenstein 3D', 'PC (MS-DOS)', 1992, 'FPS', 0]
            ];
            
            $added = 0; $skipped = 0;
            $check = $conn->prepare("SELECT id FROM game_collection WHERE title = ? AND platform = ?");
            $insert = $conn->prepare("INSERT INTO game_collection (title, platform, release_year, genre, is_completed) VALUES (?, ?, ?, ?, ?)");

            foreach ($games as $g) {
                $check->bind_param("ss", $g[0], $g[1]);
                $check->execute();
                $check->store_result();
                if ($check->num_rows === 0) {
                    $insert->bind_param("ssisi", $g[0], $g[1], $g[2], $g[3], $g[4]);
                    $insert->execute();
                    $added++;
                } else {
                    $skipped++;
                }
            }

            echo "<div class='message'><strong>SYSTEM:</strong> Operations Complete.</div>";
            echo "<div class='message'>$added records linked to library.</div>";
            if ($skipped > 0) {
                echo "<div class='message warning-msg'>$skipped redundant entries ignored.</div>";
            }
            
            $check->close(); $insert->close();
        } else {
            echo "<div class='message error-msg'>FATAL: Table 'game_collection' not found.</div>";
        }
    } catch (mysqli_sql_exception $e) {
        echo "<div class='message error-msg'>ERROR: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
    ?>
    <a href="index.php" class="btn btn-back">Return to Prompt</a>
</div>
</body>
</html>