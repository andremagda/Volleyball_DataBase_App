<?php
require_once "../db_connect.php";

// Initialize location_id from GET or POST
$location_id = isset($_POST['location_id']) ? $_POST['location_id'] : (isset($_GET['location_id']) ? $_GET['location_id'] : null);

// Handle prompt form submission to load location
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prompt_location_id'])) {
    $location_id = $_POST['prompt_location_id'];
}

// Handle deletion confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete']) && $location_id) {
    $query = "DELETE FROM Locations WHERE location_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $location_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $success_message = "Location with ID $location_id deleted successfully!";
            $location_id = null; // Reset to show prompt again
        } else {
            $error_message = "No location found with ID $location_id to delete.";
        }
    } else {
        $error_message = "Error deleting location: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch location data if location_id is provided (for confirmation)
$location = null;
if ($location_id) {
    $query = "SELECT * FROM Locations WHERE location_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $location_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $location = $result->fetch_assoc();

    if (!$location) {
        $error_message = "Location with ID $location_id not found.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Delete Location</title>
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

    <h2>Delete Location</h2>

    <?php
    if (isset($success_message)) {
        echo "<div class='message success'>$success_message</div>";
    }
    if (isset($error_message)) {
        echo "<div class='message error'>$error_message</div>";
    }
    ?>

    <?php if (!$location_id): ?>
        <!-- Prompt form to enter location_id -->
        <form method="post" action="delete_locations.php">
            <label for="prompt_location_id">Enter Location ID to Delete:</label>
            <input type="number" name="prompt_location_id" required>
            <input type="submit" value="Load Location" class="load-btn">
        </form>
    <?php elseif ($location): ?>
        <!-- Confirmation form -->
        <div class="confirmation">
            <h3>Confirm Deletion</h3>
            <p>Are you sure you want to delete the following location?</p>
            <ul>
                <li><strong>ID:</strong> <?php echo htmlspecialchars($location['location_id']); ?></li>
                <li><strong>Name:</strong> <?php echo htmlspecialchars($location['location_name']); ?></li>
                <li><strong>Address:</strong> <?php echo htmlspecialchars($location['address']); ?></li>
                <li><strong>City:</strong> <?php echo htmlspecialchars($location['city']); ?></li>
                <li><strong>Province:</strong> <?php echo htmlspecialchars($location['province']); ?></li>
                <li><strong>Postal Code:</strong> <?php echo htmlspecialchars($location['postal_code']); ?></li>
                <li><strong>Web Address:</strong> <?php echo htmlspecialchars($location['web_address']); ?></li>
                <li><strong>Max Capacity:</strong> <?php echo htmlspecialchars($location['max_capacity']); ?></li>
                <li><strong>Type:</strong> <?php echo htmlspecialchars($location['location_type']); ?></li>
                <li><strong>Phone Number:</strong> <?php echo htmlspecialchars($location['phone_number']); ?></li>
            </ul>
            <form method="post" action="delete_locations.php">
                <input type="hidden" name="location_id" value="<?php echo htmlspecialchars($location['location_id']); ?>">
                <input type="hidden" name="confirm_delete" value="1">
                <input type="submit" value="Yes, Delete"  class="delete-btn">
                <a href="delete_locations.php" style="margin-left: 10px;">No, Cancel</a>
            </form>
        </div>
    <?php endif; ?>

    <div class="button-row">
        <a href="view_locations.php" class="btn">Location List</a>
        <a href="../main.php" class="btn">Back to Main Page</a>
    </div>
    </section>
</body>
</html>

