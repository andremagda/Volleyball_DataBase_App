<?php
require_once "../db_connect.php";

// Initialize clubmember_id from GET or POST
$clubmember_id = isset($_POST['clubmember_id']) ? $_POST['clubmember_id'] : (isset($_GET['clubmember_id']) ? $_GET['clubmember_id'] : null);

// Handle prompt form submission to load club member
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prompt_clubmember_id'])) {
    $clubmember_id = $_POST['prompt_clubmember_id'];
}

// Handle deletion confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete']) && $clubmember_id) {
    $query = "DELETE FROM Clubmembers WHERE clubmember_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $clubmember_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $success_message = "Club member with ID $clubmember_id deleted successfully!";
            $clubmember_id = null; // Reset to show prompt again
        } else {
            $error_message = "No club member found with ID $clubmember_id to delete.";
        }
    } else {
        $error_message = "Error deleting club member: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch club member data if clubmember_id is provided (for confirmation)
$club_member = null;
if ($clubmember_id) {
    $query = "SELECT * FROM Clubmembers WHERE clubmember_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $clubmember_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $club_member = $result->fetch_assoc();

    if (!$club_member) {
        $error_message = "Club member with ID $clubmember_id not found.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Club Member</title>
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

    <h2>Delete Club Member</h2>

    <?php
    if (isset($success_message)) {
        echo "<div class='message success'>$success_message</div>";
    }
    if (isset($error_message)) {
        echo "<div class='message error'>$error_message</div>";
    }
    ?>

    <?php if (!$clubmember_id): ?>
        <!-- Prompt form to enter clubmember_id -->
        <form method="post" action="delete_clubmembers.php">
            <label for="prompt_clubmember_id">Enter Club Member ID to Delete:</label>
            <input type="number" name="prompt_clubmember_id" required>
            <input type="submit" value="Load Club Member" class="load-btn">
        </form>
    <?php elseif ($club_member): ?>
        <!-- Confirmation form -->
        <div class="confirmation">
            <h3>Confirm Deletion</h3>
            <p>Are you sure you want to delete the following club member?</p>
            <ul>
                <li><strong>ID:</strong> <?php echo htmlspecialchars($club_member['clubmember_id']); ?></li>
                <li><strong>First Name:</strong> <?php echo htmlspecialchars($club_member['first_name']); ?></li>
                <li><strong>Last Name:</strong> <?php echo htmlspecialchars($club_member['last_name']); ?></li>
                <li><strong>Date of Birth:</strong> <?php echo htmlspecialchars($club_member['date_of_birth']); ?></li>
                <li><strong>Height:</strong> <?php echo htmlspecialchars($club_member['height']); ?></li>
                <li><strong>Weight:</strong> <?php echo htmlspecialchars($club_member['weight']); ?></li>
                <li><strong>SSN:</strong> <?php echo htmlspecialchars($club_member['ssn']); ?></li>
                <li><strong>Telephone Number:</strong> <?php echo htmlspecialchars($club_member['telephone_number']); ?></li>
                <li><strong>Address:</strong> <?php echo htmlspecialchars($club_member['address']); ?></li>
                <li><strong>City:</strong> <?php echo htmlspecialchars($club_member['city']); ?></li>
                <li><strong>Province:</strong> <?php echo htmlspecialchars($club_member['province']); ?></li>
                <li><strong>Postal Code:</strong> <?php echo htmlspecialchars($club_member['postal_code']); ?></li>
                <li><strong>Gender:</strong> <?php echo htmlspecialchars($club_member['gender']); ?></li>
                <li><strong>Team ID:</strong> <?php echo htmlspecialchars($club_member['teams_id']); ?></li>
                <li><strong>Status:</strong> <?php echo htmlspecialchars($club_member['status']); ?></li>
                <li><strong>Medicare:</strong> <?php echo htmlspecialchars($club_member['medicare']); ?></li>
                <li><strong>Email:</strong> <?php echo htmlspecialchars($club_member['email']); ?></li>
                <li><strong>Deactivation Date:</strong> <?php echo htmlspecialchars($club_member['deactivation_date']); ?></li>
            </ul>
            <form method="post" action="delete_clubmembers.php">
                <input type="hidden" name="clubmember_id" value="<?php echo htmlspecialchars($club_member['clubmember_id']); ?>">
                <input type="hidden" name="confirm_delete" value="1">
                <input type="submit" value="Yes, Delete" class="delete-btn">
                <a href="delete_clubmembers.php" style="margin-left: 10px;">No, Cancel</a>
            </form>
        </div>
    <?php endif; ?>

    <div class="button-row">
        <a href="view_clubmembers.php" class="btn">Club Members List</a>
        <a href="../main.php" class="btn">Back to Main Page</a>
    </div>
    
    </section>
</body>
</html>
