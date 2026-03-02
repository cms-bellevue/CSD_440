<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 9 Programming Assignment
 * Add Record Form
 * 03/01/2026
 *
 * This program:
 * - Provides an HTML form to input new retro game data
 * - Verifies if a title/platform combination already exists
 * - Implements PRG pattern to prevent double-entry on refresh
 * - Uses prepared statements to prevent SQL injection
 */

require_once __DIR__ . '/ClintDbConfig.php';
$conn = get_db_connection();
session_start();

$message = isset($_SESSION['message']) ? $_SESSION['message'] : "";
unset($_SESSION['message']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $title = trim($_POST['title']);
        $platform = trim($_POST['platform']);
        $year = (int)$_POST['release_year'];
        $genre = trim($_POST['genre']);
        $status = isset($_POST['is_completed']) ? 1 : 0;

        // Duplicate Check: Look for title + platform combination
        $check = $conn->prepare("SELECT id FROM game_collection WHERE title = ? AND platform = ?");
        $check->bind_param("ss", $title, $platform);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $_SESSION['message'] = "<div class='message warning-msg'>SYSTEM: Entry '" . htmlspecialchars($title) . "' on " . htmlspecialchars($platform) . " already exists.</div>";
        } else {
            $stmt = $conn->prepare("INSERT INTO game_collection (title, platform, release_year, genre, is_completed) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssisi", $title, $platform, $year, $genre, $status);
            
            if ($stmt->execute()) {
                $_SESSION['message'] = "<div class='message success-msg'>SYSTEM: New entry '" . htmlspecialchars($title) . "' linked to library.</div>";
            }
            $stmt->close();
        }
        $check->close();

        // Redirect to same page to clear POST data (Prevents refresh resubmit)
        header("Location: ClintAddGame.php");
        exit();

    } catch (mysqli_sql_exception $e) {
        $_SESSION['message'] = "<div class='message error-msg'>FATAL: " . htmlspecialchars($e->getMessage()) . "</div>";
        header("Location: ClintAddGame.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Title</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Add New Retro Title</h2>
    <?php echo $message; ?>
    <form action="ClintAddGame.php" method="post">
        <div class="form-group"><label>Title:</label><input type="text" name="title" required></div>
        <div class="form-group"><label>Platform:</label><input type="text" name="platform" required></div>
        <div class="form-group">
            <label>Release Year:</label>
            <select name="release_year" required>
                <?php
                for ($y = 2026; $y >= 1958; $y--) {
                    echo "<option value='$y' " . ($y == 1990 ? "selected" : "") . ">$y</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group"><label>Genre:</label><input type="text" name="genre" required></div>
        <div class="form-group">
            <label class="checkbox-container">
                <span class="checkbox-label">Completed?</span>
                <input type="checkbox" name="is_completed" value="1">
                <span class="checkmark"></span>
            </label>
        </div>
        <button type="submit" class="btn">EXECUTE_INSERT</button>
    </form>
    <a href="index.php" class="btn btn-back">Back to Index</a>
</div>
</body>
</html>