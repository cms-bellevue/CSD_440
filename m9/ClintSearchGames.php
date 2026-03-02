<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 9 Programming Assignment
 * Search Records
 * 03/01/2026
 *
 * This program:
 * - Provides a search interface for the game_collection table
 * - Queries records across title, platform, and genre fields
 * - Implements PRG pattern to clear search results on refresh
 * - Displays results with headers matching ClintTestTable.php
 */

require_once __DIR__ . '/ClintDbConfig.php';
$conn = get_db_connection();
session_start();

// Handle search submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['search_term'] = trim($_POST['search']);
    header("Location: ClintSearchGames.php");
    exit();
}

$search_query = isset($_SESSION['search_term']) ? $_SESSION['search_term'] : null;
$results = null;

// Clear session so a fresh refresh wipes the results
unset($_SESSION['search_term']);

if ($search_query !== null) {
    if ($search_query !== "") {
        $stmt = $conn->prepare("SELECT title, platform, release_year, genre, is_completed 
                                FROM game_collection 
                                WHERE title LIKE ? OR platform LIKE ? OR genre LIKE ? 
                                ORDER BY title ASC");
        $term = "%$search_query%";
        $stmt->bind_param("sss", $term, $term, $term);
        $stmt->execute();
        $results = $stmt->get_result();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Library</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Search Game Library</h2>
    
    <div class="message">
        <strong>HINT:</strong> Searchable by Title, Platform, or Genre.
    </div>

    <form action="ClintSearchGames.php" method="post">
        <input type="text" name="search" class="search-bar" 
               placeholder="Enter search term...">
        <button type="submit" class="btn search-btn">QUERY</button>
    </form>

    <?php 
    if ($search_query === "") {
        echo "<div class='message warning-msg'>SYSTEM: Query rejected. You need to enter search criteria.</div>";
    } elseif ($results) {
        if ($results->num_rows > 0) {
            echo "<table><thead><tr>";
            echo "<th><a>Title</a></th>";
            echo "<th><a>Platform</a></th>";
            echo "<th><a>Year</a></th>";
            echo "<th><a>Genre</a></th>";
            echo "<th><a>Completed</a></th>";
            echo "</tr></thead><tbody>";
            while($row = $results->fetch_assoc()) {
                $status = $row['is_completed'] ? 'Yes' : 'No';
                echo "<tr>";
                echo "<td>".htmlspecialchars($row['title'])."</td>";
                echo "<td>".htmlspecialchars($row['platform'])."</td>";
                echo "<td>".$row['release_year']."</td>";
                echo "<td>".htmlspecialchars($row['genre'])."</td>";
                echo "<td>$status</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='message warning-msg'>SYSTEM: No matches found for '".htmlspecialchars($search_query)."'.</div>";
        }
    }
    ?>

    <a href="index.php" class="btn btn-back">Back to Index</a>
</div>
</body>
</html>