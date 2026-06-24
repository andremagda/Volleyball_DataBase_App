<?php
require_once "../db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $teams_id = $_POST['teams_id'];
    $session_type = $_POST['session_type'];
    $session_date = $_POST['session_date'];
    $session_time = $_POST['session_time'];
    $session_address = $_POST['session_address'];

    // Prepare SQL query to insert data into Session table
    $query = "INSERT INTO Session (teams_id, session_type, session_date, session_time, session_address)
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Bind parameters to the query
    $stmt->bind_param("issss",
        $teams_id,
        $session_type,
        $session_date,
        $session_time,
        $session_address
    );

    // Execute the query and handle the result
    if ($stmt->execute()) {
        $success_message = "Session added successfully!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }
    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Session</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .message {
            padding: 10px;
            margin

: 10px 0;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
<h1>Volleyball Club</h1>
<section class="form-section">

    <h2>Create a New Session</h2><br>

    <?php
    if (isset($success_message)) {
        echo "<div class='message success'>$success_message</div>";
    }
    if (isset($error_message)) {
        echo "<div class='message error'>$error_message</div>";
    }
    ?>

    <form method="post" action="create_session.php">
        <div class="form-row">
        <label for="teams_id">Team ID:</label>
        <input type="number" name="teams_id" required>
        </div>

        <div class="form-row">
        <label for="session_type">Session Type:</label>
        <select name="session_type">
            <option value="training">Training</option>
            <option value="game">Game</option>
        </select>
        </div>

        <div class="form-row">
        <label for="session_date">Session Date:</label>
        <input type="date" name="session_date">
        </div>

        <div class="form-row">
        <label for="session_time">Session Time:</label>
        <input type="time" name="session_time">
        </div>

        <div class="form-row">
        <label for="session_address">Session Address:</label>
        <input type="text" name="session_address">
        </div>

        <input type="submit" value="Add Session" class="submit-btn">
        <a href="../main.php" class="back-btn">Back to Main Page</a>

    </form>
</body>
</html>

<?php
// Connection will be closed in main.php if needed
?>
