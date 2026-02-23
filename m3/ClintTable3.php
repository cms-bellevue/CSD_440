<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 3 Programming Assignment
 * 1/25/2026
 * Comment: Generate an HTML table using nested PHP loops with an external function call
 */

// Include the external functions file
require_once __DIR__ . '/function_sum.php';

// Define the dimensions of the table
$rows = 10;
$cols = 5;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ClintTable3 - Summation Table</title>
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
    <h2>Random Number Summation Table</h2>
    <table aria-label="Table showing sums of random numbers">
        <?php for ($i = 0; $i < $rows; $i++): ?>
            <tr>
                <?php for ($j = 0; $j < $cols; $j++): ?>
                    <td>
                        <?php
                            $val1 = random_int(1, 50);
                            $val2 = random_int(1, 50);
                            
                            echo calculateCellSum($val1, $val2);
                        ?>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>
</body>
</html>