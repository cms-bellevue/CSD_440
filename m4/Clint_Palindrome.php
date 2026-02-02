<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 4 Programming Assignment
 * 2/1/2026
 * Comment: Tests strings to determine if they are palindromes.
 */

/**
 * Cleans a string by removing non-alphanumeric characters and converting it to lowercase.
 *
 * @param string $str The input string.
 * @return string The cleaned string.
 */
function cleanString($str) {
    return strtolower(preg_replace("/[^A-Za-z0-9]/", '', $str));
}

/**
 * Checks if a string reads the same forwards and backwards.
 *
 * @param string $str The input string to test.
 * @return bool True if palindrome, false otherwise.
 */
function isPalindrome($str) {
    $cleanStr = cleanString($str);
    return $cleanStr === strrev($cleanStr);
}

// Data set: 3 palindromes and 3 non-palindromes
$testStrings = [
    "Was it a rat I saw?",	// Palindrome
    "Draw, O coward!",		// Palindrome
    "Never odd or even",	// Palindrome
    "Dragonlance",			// Not a palindrome
    "Critical hit!",		// Not a palindrome
    "Chain Lightning"		// Not a palindrome
];

echo "<h2>Palindrome Test Results</h2>";

// Simple table for a cleaner layout
echo "<table border='1' cellpadding='10' style='border-collapse: collapse; font-family: Arial, sans-serif;'>";
echo "<tr style='background-color: #f2f2f2;'>
        <th>Original String</th>
        <th>Evaluated (Cleaned)</th>
        <th>Reversed Order</th>
        <th>Result</th>
      </tr>";

// Process each test string
foreach ($testStrings as $test) {
    $clean = cleanString($test);
    $reversed = strrev($clean);
    $result = isPalindrome($test) ? "YES" : "NO";
    
    // Set a background color for the result cell based on pass/fail
    $color = ($result === "YES") ? "#d4edda" : "#f8d7da";

    echo "<tr>";
    echo "<td>$test</td>";
    echo "<td>$clean</td>";
    echo "<td>$reversed</td>";
    echo "<td style='background-color: $color; text-align: center; font-weight: bold;'>$result</td>";
    echo "</tr>";
}

echo "</table>";
?>