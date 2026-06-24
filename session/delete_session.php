<?php
require_once "../db_connect.php";

// Initialize session_id from GET or POST
$session_id = isset($_POST['session_id']) ? $_POST['session_id'] : (isset($_GET['session_id']) ? $_GET['session_id'] : null);

// Handle prompt form submission to load session
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prompt_session_id'])) {
    $session_id = $_POST['prompt_session_id'];
}

// Handle deletion confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete']) && $session_id) {
    $query = "DELETE FROM Session WHERE session_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $session_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $success_message = "Session with ID $session_id deleted successfully!";
            $session_id = null; // Reset to show prompt again
        } else {
            $error_message = "No session found with ID $session_id to delete.";
        }
    } else {
        $error_message = "Error deleting session: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch session data if session_id is provided (for confirmation)
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
    <title>Delete Session</title>
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
        .confirmation {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h2>Delete Session</h2>

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
        <form method="post" action="delete_session.php">
            <label for="prompt_session_id">Enter Session ID to Delete:</label>
            <input type="number" name="prompt_session_id" required>
            <input type="submit" value="Load Session">
        </form>
    <?php elseif ($session): ?>
        <!-- Confirmation form -->
        <div class="confirmation">
            <h3>Confirm Deletion</h3>
            <p>Are you sure you want to delete the following session?</p>
            <ul>
                <li><strong>Session ID:</strong> <?php echo htmlspecialchars($session['session_id']); ?></li>
                <li><strong>Team ID:</strong> <?php echo htmlspecialchars($session['teams_id']); ?></li>
                <li><strong>Session Type:</strong> <?php echo htmlspecialchars($session['session_type']); ?></li>
                <li><strong>Session Date:</strong> <?php echo htmlspecialchars($session['session_date']); ?></li>
                <li><strong>Session Time:</strong> <?php echo htmlspecialchars($session['session_time']); ?></li>
                <li><strong>Session Address:</strong> <?php echo htmlspecialchars($session['session_address']); ?></li>
            </ul>
            <form method="post" action="delete_session.php">
                <input type="hidden" name="session_id" value="<?php echo htmlspecialchars($session['session_id']); ?>">
                <input type="hidden" name="confirm_delete" value="1">
                <input type="submit" value="Yes, Delete" style="background-color: #ff4444; color: white;">
                <a href="delete_session.php" style="margin-left: 10px;">No, Cancel</a>
            </form>
        </div>
    <?php endif; ?>

    <p><a href="../session/view_session.php">Back to Sessions List</a></p>

</body>
</html>

