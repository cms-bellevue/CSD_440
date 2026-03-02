<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 8 Programming Assignment
 * Query Test Script
 * 02/23/2026
 *
 * This program:
 * - Retrieves all records including completion status from the collection
 * - Implements dynamic column sorting via GET parameters
 * - Enforces strict ascending order for all data views
 * - Formats results into an HTML table with XSS prevention
 */

require_once __DIR__ . '/ClintDbConfig.php';
$conn = get_db_connection();

$allowed_columns = ['title', 'platform', 'release_year', 'genre', 'is_completed'];
$sort = isset($_GET['sort']) && in_array($_GET['sort'], $allowed_columns) ? $_GET['sort'] : 'title';
$order = 'ASC';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Collection Audit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Game Collection Report</h2>
    <?php
    try {
        $sql = "SELECT title, platform, release_year, genre, is_completed 
                FROM game_collection 
                ORDER BY $sort $order";
        
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo "<table><thead><tr>";
            echo "<th><a href='?sort=title'>Title</a></th>";
            echo "<th><a href='?sort=platform'>Platform</a></th>";
            echo "<th><a href='?sort=release_year'>Year</a></th>";
            echo "<th><a href='?sort=genre'>Genre</a></th>";
            echo "<th><a href='?sort=is_completed'>Completed</a></th>";
            echo "</tr></thead><tbody>";

            while($row = $result->fetch_assoc()) {
                $status = $row['is_completed'] ? 'Yes' : 'No';
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                echo "<td>" . htmlspecialchars($row['platform']) . "</td>";
                echo "<td>" . htmlspecialchars($row['release_year']) . "</td>";
                echo "<td>" . htmlspecialchars($row['genre']) . "</td>";
                echo "<td>" . $status . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='message'>Collection is empty.</div>";
        }
    } catch (mysqli_sql_exception $e) {
        echo "<div class='message error-msg'>Notice: Table missing. Run Create Table script first.</div>";
    }
    ?>
    <a href="index.php" class="btn btn-back">Back to Index</a>
</div>
</body>
</html>