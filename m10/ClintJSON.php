<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 10 Programming Assignment
 * JSON Encoder CGI
 * 03/08/2026
 *
 * This program:
 * - Receives POST data from the audit form
 * - Validates text and numeric input fields
 * - Encodes valid data using json_encode
 * - Displays formatted JSON output
 * - Returns descriptive error messages if validation fails
 */

$output = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST)) {

    $formData = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    $errors   = [];

    if (!preg_match("/^[A-Za-z\s]{2,40}$/", $formData["teammate_name"])) {
        $errors[] = "Teammate name must contain letters only.";
    }

    if (!preg_match("/^[A-Za-z\s]{2,40}$/", $formData["claimed_skill"])) {
        $errors[] = "Skillset must contain letters only.";
    }

    if (!preg_match("/^[A-Za-z\s]{2,100}$/", $formData["excuse_log"])) {
        $errors[] = "Excuse must be text only.";
    }

    if (!filter_var($formData["attendance"], FILTER_VALIDATE_INT)) {
        $errors[] = "Attendance must be numeric.";
    }

    if (!filter_var($formData["slack_lag"], FILTER_VALIDATE_INT)) {
        $errors[] = "Response time must be numeric.";
    }

    if (!filter_var($formData["quality_score"], FILTER_VALIDATE_INT)) {
        $errors[] = "Quality score must be numeric.";
    }

    if (!filter_var($formData["rehire_probability"], FILTER_VALIDATE_INT)) {
        $errors[] = "Rehire probability must be numeric.";
    }

    if (empty($errors)) {

        $jsonResult = json_encode($formData, JSON_PRETTY_PRINT);

        if ($jsonResult !== false) {

            $output  = "<h2>Audit Results: JSON Format</h2>";
            $output .= "<pre>{$jsonResult}</pre>";

        } else {

            $output  = "<h2>Encoding Error</h2>";
            $output .= "<p class='error-text'>Failed to generate JSON output.</p>";

        }

    } else {

        $output  = "<h2>Validation Error</h2>";
        $output .= "<ul class='error-text'>";

        foreach ($errors as $error) {
            $output .= "<li>{$error}</li>";
        }

        $output .= "</ul>";

    }

} else {

    $output  = "<h2>Input Error</h2>";
    $output .= "<p class='error-text'>No data received. Please submit the form.</p>";

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>JSON Audit Result</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <?php echo $output; ?>

    <a class="back-link" href="ClintForm.html">← Return to Audit Form</a>

</div>

</body>
</html>