<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 9 Programming Assignment
 * Retro Gaming Collection Interface
 * 03/01/2026
 *
 * This program:
 * - Provides a centralized UI for managing the retro game collection
 * - Links to Search, Add, View, Create, Populate, and Drop operations
 * - Includes all required files from Module 8 for full system management
 * - Utilizes the style.css gaming theme for a professional layout
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Retro Gaming Collection Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Retro Gaming Collection Manager</h2>
    <nav>
        <div class="tool-group">
            <p>LIBRARY TOOLS:</p>
            <a href="ClintSearchGames.php" class="btn">Search Game Library</a>
            <a href="ClintAddGame.php" class="btn">Add New Game Title</a>
            <a href="ClintTestTable.php" class="btn">View Entire Collection</a>
        </div>
        
        <div class="tool-group">
            <p>ADMINISTRATIVE TOOLS:</p>
            <a href="ClintCreateTable.php" class="btn">Initialize Database Table</a>
            <a href="ClintPopulateTable.php" class="btn">Run Default Population</a>
            <a href="ClintDropTable.php" class="btn btn-danger">Purge Collection Table</a>
        </div>
    </nav>
</div>
</body>
</html>