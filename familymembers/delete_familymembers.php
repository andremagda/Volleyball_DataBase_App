<?php
require_once "../db_connect.php";

// Initialize familymember_id from GET or POST
$familymember_id = isset($_POST['familymember_id']) ? $_POST['familymember_id'] : (isset($_GET['familymember_id']) ? $_GET['familymember_id'] : null);

// Handle prompt form submission to load family member
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prompt_familymember_id'])) {
    $familymember_id = $_POST['prompt_familymember_id'];
}

// Handle deletion confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete']) && $familymember_id) {
    $query = "DELETE FROM Familymembers WHERE familymember_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $familymember_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $success_message = "Family member with ID $familymember_id deleted successfully!";
            $familymember_id = null; // Reset to show prompt again
        } else {
            $error_message = "No family member found with ID $familymember_id to delete.";
        }
    } else {
        $error_message = "Error deleting family member: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch family member data if familymember_id is provided (for confirmation)
$family_member = null;
if ($familymember_id) {
    $query = "SELECT * FROM Familymembers WHERE familymember_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $familymember_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $family_member = $result->fetch_assoc();

    if (!$family_member) {
        $error_message = "Family member with ID $familymember_id not found.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Family Member</title>
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

    <h2>Delete Family Member</h2>

    <?php
    if (isset($success_message)) {
        echo "<div class='message success'>$success_message</div>";
    }
    if (isset($error_message)) {
        echo "<div class='message error'>$error_message</div>";
    }
    ?>

    <?php if (!$familymember_id): ?>
        <!-- Prompt form to enter familymember_id -->
        <form method="post" action="delete_familymembers.php">
            <label for="prompt_familymember_id">Enter Family Member ID to Delete:</label>
            <input type="number" name="prompt_familymember_id" required>
            <input type="submit" value="Load Family Member" class="load-btn">
        </form>
    <?php elseif ($family_member): ?>
        <!-- Confirmation form -->
        <div class="confirmation">
            <h3>Confirm Deletion</h3>
            <p>Are you sure you want to delete the following family member?</p>
            <ul>
                <li><strong>ID:</strong> <?php echo htmlspecialchars($family_member['familymember_id']); ?></li>
                <li><strong>First Name:</strong> <?php echo htmlspecialchars($family_member['first_name']); ?></li>
                <li><strong>Last Name:</strong> <?php echo htmlspecialchars($family_member['last_name']); ?></li>
                <li><strong>Date of Birth:</strong> <?php echo htmlspecialchars($family_member['date_of_birth']); ?></li>
                <li><strong>SSN:</strong> <?php echo htmlspecialchars($family_member['ssn']); ?></li>
                <li><strong>Telephone Number:</strong> <?php echo htmlspecialchars($family_member['telephone_number']); ?></li>
                <li><strong>Address:</strong> <?php echo htmlspecialchars($family_member['address']); ?></li>
                <li><strong>City:</strong> <?php echo htmlspecialchars($family_member['city']); ?></li>
                <li><strong>Province:</strong> <?php echo htmlspecialchars($family_member['province']); ?></li>
                <li><strong>Postal Code:</strong> <?php echo htmlspecialchars($family_member['postal_code']); ?></li>
                <li><strong>Email:</strong> <?php echo htmlspecialchars($family_member['email']); ?></li>
                <li><strong>Medicare:</strong> <?php echo htmlspecialchars($family_member['medicare']); ?></li>
                <li><strong>Related Family Member ID:</strong> <?php echo htmlspecialchars($family_member['familymember2_id']); ?></li>
            </ul>
            <form method="post" action="delete_familymembers.php">
                <input type="hidden" name="familymember_id" value="<?php echo htmlspecialchars($family_member['familymember_id']); ?>">
                <input type="hidden" name="confirm_delete" value="1">
                <input type="submit" value="Yes, Delete"  class="delete-btn">
                <a href="delete_familymembers.php" style="margin-left: 10px;">No, Cancel</a>
            </form>
        </div>
    <?php endif; ?>

    <div class="button-row">
        <a href="view_familymembers.php" class="btn">Family Members List</a>
        <a href="../main.php" class="btn">Back to Main Page</a>
    </div>
    </section>
</body>
</html>

