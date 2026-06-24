<?php
require_once "../db_connect.php";

// Initialize session_id from GET or POST
$session_id = isset($_POST['session_id']) ? $_POST['session_id'] : (isset($_GET['session_id']) ? $_GET['session_id'] : null);

// Handle prompt form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prompt_session_id'])) {
    $session_id = $_POST['prompt_session_id'];
}

// Handle session update submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['teams_id'])) {
    $teams_id = $_POST['teams_id'];
    $session_type = $_POST['session_type'];
    $session_date = $_POST['session_date'];
    $session_time = $_POST['session_time'];
    $session_address = $_POST['session_address'];

    $query = "UPDATE Session SET
              teams_id = ?,
              session_type = ?,
              session_date = ?,
              session_time = ?,
              session_address = ?
              WHERE session_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issssi",
        $teams_id, $session_type, $session_date, $session_time, $session_address, $session_id
    );

    if ($stmt->execute()) {
        $success_message = "Session updated successfully!";
    } else {
        $error_message = "Error updating session: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch session data if session_id is provided
$session = null;
if ($session_id) {
    $query = "SELECT * FROM Session WHERE session_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $session_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $session = $result->fetch_assoc();

    if (!$session) {
        $error_message = "Session with ID $session_id not found.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Session</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .message {
            padding: 10px;
            margin: 10px 0;
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
    <h2>Edit Session</h2>

    <?php
    if (isset($success_message)) {
        echo "<div class='message success'>$success_message</div>";
    }
    if (isset($error_message)) {
        echo "<div class='message error'>$error_message</div>";
    }
    ?>

    <?php if (!$session_id): ?>
        <!-- Prompt form to enter session_id -->
        <form method="post" action="update_session.php">
            <label for="prompt_session_id">Enter Session ID to Edit:</label>
            <input type="number" name="prompt_session_id" required>
            <input type="submit" value="Load Session">
        </form>
    <?php elseif ($session): ?>
        <!-- Edit form for the selected session -->
        <form method="post" action="update_session.php">
            <input type="hidden" name="session_id" value="<?php echo htmlspecialchars($session['session_id']); ?>">

            <label for="teams_id">Team ID:</label>
            <input type="number" name="teams_id" value="<?php echo htmlspecialchars($session['teams_id']); ?>" required>
            <br><br>

            <label for="session_type">Session Type:</label>
            <select name="session_type">
                <option value="training" <?php echo $session['session_type'] === 'training' ? 'selected' : ''; ?>>Training</option>
                <option value="game" <?php echo $session['session_type'] === 'game' ? 'selected' : ''; ?>>Game</option>
            </select>
            <br><br>

            <label for="session_date">Session Date:</label>
            <input type="date" name="session_date" value="<?php echo htmlspecialchars($session['session_date']); ?>">
            <br><br>

            <label for="session_time">Session Time:</label>
            <input type="time" name="session_time" value="<?php echo htmlspecialchars($session['session_time']); ?>">
            <br><br>

            <label for="session_address">Session Address:</label>
            <input type="text" name="session_address" value="<?php echo htmlspecialchars($session['session_address']); ?>">
            <br><br>

            <input type="submit" value="Update Session">
        </form>
    <?php endif; ?>

    <p><a href="../session/view_session.php">Back to Sessions List</a></p>

</body>
</html>

