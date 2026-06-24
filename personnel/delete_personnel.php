<?php
require_once "../db_connect.php";

// Initialize personnel_id from GET or POST
$personnel_id = isset($_POST['personnel_id']) ? $_POST['personnel_id'] : (isset($_GET['personnel_id']) ? $_GET['personnel_id'] : null);

// Handle prompt form submission to load personnel
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prompt_personnel_id'])) {
    $personnel_id = $_POST['prompt_personnel_id'];
}

// Handle deletion confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete']) && $personnel_id) {
    $query = "DELETE FROM Personnel WHERE personnel_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $personnel_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $success_message = "Personnel with ID $personnel_id deleted successfully!";
            $personnel_id = null; // Reset to show prompt again
        } else {
            $error_message = "No personnel found with ID $personnel_id to delete.";
        }
    } else {
        $error_message = "Error deleting personnel: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch personnel data if personnel_id is provided (for confirmation)
$personnel = null;
if ($personnel_id) {
    $query = "SELECT * FROM Personnel WHERE personnel_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $personnel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $personnel = $result->fetch_assoc();

    if (!$personnel) {
        $error_message = "Personnel with ID $personnel_id not found.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Personnel</title>
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
<h1>Volleyball Club</h1>
<section class="delete-section"> 

    <h2>Delete Personnel</h2>

    <?php
    if (isset($success_message)) {
        echo "<div class='message success'>$success_message</div>";
    }
    if (isset($error_message)) {
        echo "<div class='message error'>$error_message</div>";
    }
    ?>

    <?php if (!$personnel_id): ?>
        <!-- Prompt form to enter personnel_id -->
        <form method="post" action="delete_personnel.php">
            <label for="prompt_personnel_id">Enter Personnel ID to Delete:</label>
            <input type="number" name="prompt_personnel_id" required>
            <input type="submit" value="Load Personnel" class="load-btn">
        </form>
    <?php elseif ($personnel): ?>
        <!-- Confirmation form -->
        <div class="confirmation">
            <h3>Confirm Deletion</h3>
            <p>Are you sure you want to delete the following personnel?</p>
            <ul>
                <li><strong>ID:</strong> <?php echo htmlspecialchars($personnel['personnel_id']); ?></li>
                <li><strong>First Name:</strong> <?php echo htmlspecialchars($personnel['first_name']); ?></li>
                <li><strong>Last Name:</strong> <?php echo htmlspecialchars($personnel['last_name']); ?></li>
                <li><strong>Date of Birth:</strong> <?php echo htmlspecialchars($personnel['date_of_birth']); ?></li>
                <li><strong>SSN:</strong> <?php echo htmlspecialchars($personnel['ssn']); ?></li>
                <li><strong>Medicare:</strong> <?php echo htmlspecialchars($personnel['medicare']); ?></li>
                <li><strong>Telephone Number:</strong> <?php echo htmlspecialchars($personnel['telephone_number']); ?></li>
                <li><strong>Address:</strong> <?php echo htmlspecialchars($personnel['address']); ?></li>
                <li><strong>City:</strong> <?php echo htmlspecialchars($personnel['city']); ?></li>
                <li><strong>Province:</strong> <?php echo htmlspecialchars($personnel['province']); ?></li>
                <li><strong>Postal Code:</strong> <?php echo htmlspecialchars($personnel['postal_code']); ?></li>
                <li><strong>Email:</strong> <?php echo htmlspecialchars($personnel['email']); ?></li>
                <li><strong>Mandate:</strong> <?php echo htmlspecialchars($personnel['mandate']); ?></li>
                <li><strong>Working Role:</strong> <?php echo htmlspecialchars($personnel['working_role']); ?></li>
            </ul>
            <form method="post" action="delete_personnel.php">
                <input type="hidden" name="personnel_id" value="<?php echo htmlspecialchars($personnel['personnel_id']); ?>">
                <input type="hidden" name="confirm_delete" value="1">
                <input type="submit" value="Yes, Delete"  class="delete-btn">
                <a href="delete_personnel.php" style="margin-left: 10px;">No, Cancel</a>
            </form>
        </div>
    <?php endif; ?>

    <div class="button-row">
        <a href="view_personnel.php" class="btn">Personnel List</a>
        <a href="../main.php" class="btn">Back to Main Page</a>
    </div>
    </section>
</body>
</html>

