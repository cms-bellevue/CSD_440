<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 8 Programming Assignment
 * Retro Gaming Collection Interface
 * 02/23/2026
 *
 * This program:
 * - Provides a centralized UI for managing the retro game collection
 * - Links to Create, Populate, Test, and Drop operations
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
    <h2>Retro Gaming Collection</h2>
    <nav>
        <a href="ClintCreateTable.php" class="btn">1. Initialize Game Table</a>
        <a href="ClintPopulateTable.php" class="btn">2. Populate Collection Data</a>
        <a href="ClintTestTable.php" class="btn">3. View Collection Report</a>
        <a href="ClintDropTable.php" class="btn btn-danger">4. Purge Collection Table</a>
    </nav>
</div>
</body>
</html>