<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 5 Programming Assignment
 * 2/8/2026
 *
 * This program:
 * - Creates an array of customer records
 * - Displays the full customer list
 * - Uses PHP array methods to filter customers by multiple data fields
 * - Outputs results in a reusable, formatted HTML table
 */

// ---------------------------
// Customer Data Initialization
// ---------------------------
$customers = [
    ["firstName" => "Steve",  "lastName" => "Rogers",   "age" => 105, "phone" => "212-555-0177"],
    ["firstName" => "Bruce",  "lastName" => "Wayne",    "age" => 42,  "phone" => "312-555-0199"],
    ["firstName" => "Peter",  "lastName" => "Parker",   "age" => 19,  "phone" => "718-555-0122"],
    ["firstName" => "Logan",  "lastName" => "Howlett",  "age" => 137, "phone" => "403-555-0188"],
    ["firstName" => "Selina", "lastName" => "Kyle",     "age" => 30,  "phone" => "312-555-0133"],
    ["firstName" => "Wade",   "lastName" => "Wilson",   "age" => 35,  "phone" => "800-555-0155"],
    ["firstName" => "Jean",   "lastName" => "Grey",     "age" => 28,  "phone" => "914-555-0111"],
    ["firstName" => "Matt",   "lastName" => "Murdock",  "age" => 34,  "phone" => "212-555-0144"],
    ["firstName" => "Tony",   "lastName" => "Stark",    "age" => 48,  "phone" => "212-555-0166"],
    ["firstName" => "Diana",  "lastName" => "Prince",   "age" => 800, "phone" => "202-555-0100"]
];

/**
 * Displays a list of customers in a formatted HTML table.
 *
 * @param array  $records Array of customer records
 * @param string $title   Section heading
 */
function displayTable(array $records, string $title): void {
    echo "<h2>" . htmlspecialchars($title) . "</h2>";

    if (empty($records)) {
        echo "<p class='error'>No records found.</p>";
        return;
    }

    echo "<table>";
    echo "<thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Phone Number</th>
            </tr>
          </thead>";
    echo "<tbody>";

    foreach ($records as $customer) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($customer['firstName']) . "</td>";
        echo "<td>" . htmlspecialchars($customer['lastName']) . "</td>";
        echo "<td>" . htmlspecialchars($customer['age']) . "</td>";
        echo "<td>" . htmlspecialchars($customer['phone']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clint Scott | Module 5 Assignment</title>
    <style>
        body {
            font-family: sans-serif;
            max-width: 900px;
            margin: 20px auto;
            padding: 0 20px;
            background-color: #f4f4f9;
        }
        h1 {
            border-bottom: 3px solid #e67e22;
            padding-bottom: 10px;
        }
        h2 {
            margin-top: 40px;
            font-size: 1.1rem;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin: 15px 0;
        }
        th {
            background-color: #e67e22;
            color: #fff;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background-color: #fcf3cf;
        }
        .error {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Clint’s Comics & Collectibles: Customer Portal</h1>

<?php
// ---------------------------
// Display Full Customer List
// ---------------------------
displayTable($customers, "Master Customer Registry");

// ---------------------------
// Filter by Age (40+)
// ---------------------------
$ageFiltered = array_filter($customers, fn($c) => $c['age'] >= 40);
displayTable($ageFiltered, "Filtered Results: Age 40+");

// ---------------------------
// Filter by Last Name
// ---------------------------
$targetLast = "Stark";
$lastNameFiltered = array_filter(
    $customers,
    fn($c) => strcasecmp($c['lastName'], $targetLast) === 0
);
displayTable($lastNameFiltered, "Search Results: Surname '$targetLast'");

// ---------------------------
// Filter by Phone Area Code
// ---------------------------
$areaCode = "212";
$phoneFiltered = array_filter(
    $customers,
    fn($c) => str_starts_with($c['phone'], $areaCode)
);
displayTable($phoneFiltered, "Search Results: Area Code ($areaCode)");
?>

</body>
</html>