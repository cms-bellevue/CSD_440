<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 2 Programming Assignment
 * 1/25/2026
 * Comment: Generate an HTML table using nested PHP loops
 */

// Define the dimensions of the table
$rows = 10;
$cols = 5;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ClintTable2 - Random Numbers</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px 0;
            table-layout: fixed;
        }
        td {
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
            width: 20%; 
        }
    </style>
</head>
<body>
    <h2>Random Number Table</h2>
    <table aria-label="Random number table">
        <?php for ($i = 0; $i < $rows; $i++): ?>
            <tr>
                <?php for ($j = 0; $j < $cols; $j++): ?>
                    <td>
                        <?php
                            echo random_int(1, 100);
                        ?>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>
</body>
</html>