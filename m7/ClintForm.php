<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 7 Programming Assignment
 * Help Desk Ticketing System
 * 02/15/2026
 *
 * This program:
 * - Prompts for 8 fields using 4 data types (Text, Number, Selection, Date)
 * - Implements logic to catch future dates and non-positive IDs
 * - Prevents XSS via htmlspecialchars on all output
 * - Validates string lengths to prevent buffer/UI issues
 */

date_default_timezone_set('America/New_York');

$errors = [];
$ticket_data = null;
$today = date('Y-m-d');

$allowed_departments = [
    "IT Infrastructure",
    "Observability",
    "Security Operations"
];

$allowed_systems = [
    "Active Directory",
    "Azure/Cloud",
    "Hyper-V/Virtualization",
    "Veeam/Backup"
];

$allowed_priorities = [
    "Low",
    "Medium",
    "High",
    "Critical"
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Collect and sanitize inputs
    $employee_name = trim($_POST['employee_name'] ?? '');
    $issue_subject = trim($_POST['issue_subject'] ?? '');
    $issue_details = trim($_POST['issue_details'] ?? '');
    $employee_id   = $_POST['employee_id'] ?? '';
    $department    = $_POST['department'] ?? '';
    $priority      = $_POST['priority'] ?? '';
    $system_type   = $_POST['system_type'] ?? '';
    $date_noticed  = $_POST['date_noticed'] ?? '';

    // -- VALIDATION CHECKS --

    if (
        !$employee_name || !$issue_subject || !$issue_details ||
        !$employee_id || !$department || !$priority ||
        !$system_type || !$date_noticed
    ) {
        $errors[] = "All fields must be populated before submitting the ticket.";
    }

    // Employee ID: Must be a positive integer
    if ($employee_id !== '' && filter_var($employee_id, FILTER_VALIDATE_INT) === false) {
        $errors[] = "Employee ID Number must be a valid positive integer.";
    } elseif ((int)$employee_id <= 0) {
        $errors[] = "Employee ID Number must be greater than zero.";
    }

    // Name length validation
    if ($employee_name && (strlen($employee_name) < 2 || strlen($employee_name) > 50)) {
        $errors[] = "Employee Name must be between 2 and 50 characters.";
    }

    // Subject length validation
    if ($issue_subject && strlen($issue_subject) < 5) {
        $errors[] = "Issue Subject is too short. Please provide a more descriptive title.";
    }

    // Details length validation
    if ($issue_details && strlen($issue_details) < 10) {
        $errors[] = "Issue Details must be at least 10 characters.";
    }

    // Whitelist validation
    if ($department && !in_array($department, $allowed_departments, true)) {
        $errors[] = "Invalid department selected.";
    }

    if ($system_type && !in_array($system_type, $allowed_systems, true)) {
        $errors[] = "Invalid system type selected.";
    }

    if ($priority && !in_array($priority, $allowed_priorities, true)) {
        $errors[] = "Invalid priority selected.";
    }

    // Date validation (today allowed)
    if ($date_noticed) {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_noticed)) {
            $errors[] = "Invalid date format.";
        } elseif ($date_noticed > $today) {
            $errors[] = "Date Issue Noticed cannot be a future date.";
        }
    }

    // -- DATA PROCESSING --
    if (empty($errors)) {
        $ticket_data = [
            "Ticket ID"           => "INC-" . random_int(1000, 9999),
            "Employee Name"       => htmlspecialchars($employee_name, ENT_QUOTES, 'UTF-8'),
            "Employee ID Number"  => htmlspecialchars($employee_id, ENT_QUOTES, 'UTF-8'),
            "Department"          => htmlspecialchars($department, ENT_QUOTES, 'UTF-8'),
            "System Type"         => htmlspecialchars($system_type, ENT_QUOTES, 'UTF-8'),
            "Subject"             => htmlspecialchars($issue_subject, ENT_QUOTES, 'UTF-8'),
            "Details"             => nl2br(htmlspecialchars($issue_details, ENT_QUOTES, 'UTF-8')),
            "Priority"            => htmlspecialchars($priority, ENT_QUOTES, 'UTF-8'),
            "Date Reported"       => htmlspecialchars($date_noticed, ENT_QUOTES, 'UTF-8')
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clint Scott | Help Desk Ticketing</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 30px; border-top: 6px solid #2c3e50; border-radius: 4px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .error-display { background: #fee; color: #b00; padding: 15px; border: 1px solid #fcc; margin-bottom: 20px; }
        .ticket-summary { background: #eef9ff; padding: 20px; border: 1px solid #bde0fe; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-bottom: 8px; color: #34495e; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        textarea { resize: vertical; min-height: 120px; font-family: inherit; }
        .submit-btn { background: #2c3e50; color: white; padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { text-align: left; padding: 12px; border-bottom: 1px solid #ddd; vertical-align: top; }
        th { width: 35%; color: #2c3e50; }
    </style>
</head>
<body>

<div class="container">
    <h1>IT Service Request</h1>

    <?php if (!empty($errors)): ?>
        <div class="error-display">
            <strong>The following errors must be corrected:</strong>
            <ul>
                <?php foreach ($errors as $error) echo "<li>" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "</li>"; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($ticket_data): ?>
        <div class="ticket-summary">
            <h2>Ticket Successfully Generated</h2>
            <table>
                <?php foreach ($ticket_data as $label => $content): ?>
                    <tr>
                        <th><?php echo $label; ?></th>
                        <td><?php echo $content; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <br>
            <button onclick="window.location.href='ClintForm.php'" class="submit-btn">Submit Another Request</button>
        </div>
    <?php else: ?>
        <form action="ClintForm.php" method="POST">
            <div class="form-group" style="display:flex; gap:20px;">
                <div style="flex:2;">
                    <label>Employee Name</label>
                    <input type="text" name="employee_name" value="<?php echo htmlspecialchars($employee_name ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div style="flex:1;">
                    <label>Employee ID Number</label>
                    <input type="number" name="employee_id" value="<?php echo htmlspecialchars($employee_id ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>
            </div>

            <div class="form-row" style="display:flex; gap:20px; margin-bottom: 20px;">
                <div style="flex:1;">
                    <label>Department</label>
                    <select name="department">
                        <option value="">-- Select --</option>
                        <option value="IT Infrastructure" <?php if(($department ?? '') == 'IT Infrastructure') echo 'selected'; ?>>IT Infrastructure</option>
                        <option value="Observability" <?php if(($department ?? '') == 'Observability') echo 'selected'; ?>>Observability</option>
                        <option value="Security Operations" <?php if(($department ?? '') == 'Security Operations') echo 'selected'; ?>>Security Operations</option>
                    </select>
                </div>
                <div style="flex:1;">
                    <label>System Type</label>
                    <select name="system_type">
                        <option value="">-- Select --</option>
                        <option value="Active Directory" <?php if(($system_type ?? '') == 'Active Directory') echo 'selected'; ?>>Active Directory</option>
                        <option value="Azure/Cloud" <?php if(($system_type ?? '') == 'Azure/Cloud') echo 'selected'; ?>>Azure / Cloud Services</option>
                        <option value="Hyper-V/Virtualization" <?php if(($system_type ?? '') == 'Hyper-V/Virtualization') echo 'selected'; ?>>Hyper-V / Virtualization</option>
                        <option value="Veeam/Backup" <?php if(($system_type ?? '') == 'Veeam/Backup') echo 'selected'; ?>>Veeam / Backup</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Issue Subject</label>
                <input type="text" name="issue_subject" value="<?php echo htmlspecialchars($issue_subject ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            </div>

            <div class="form-group">
                <label>Issue Details</label>
                <textarea name="issue_details"><?php echo htmlspecialchars($issue_details ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>

            <div class="form-group" style="display:flex; gap:20px;">
                <div style="flex:1;">
                    <label>Priority Level</label>
                    <select name="priority">
                        <option value="">-- Select --</option>
                        <option value="Low" <?php if(($priority ?? '') == 'Low') echo 'selected'; ?>>Low</option>
                        <option value="Medium" <?php if(($priority ?? '') == 'Medium') echo 'selected'; ?>>Medium</option>
                        <option value="High" <?php if(($priority ?? '') == 'High') echo 'selected'; ?>>High</option>
                        <option value="Critical" <?php if(($priority ?? '') == 'Critical') echo 'selected'; ?>>Critical</option>
                    </select>
                </div>
                <div style="flex:1;">
                    <label>Date Noticed</label>
                    <input type="date" name="date_noticed" max="<?php echo $today; ?>" value="<?php echo htmlspecialchars($date_noticed ?? $today, ENT_QUOTES, 'UTF-8'); ?>">
                </div>
            </div>

            <button type="submit" class="submit-btn">Submit Ticket</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>