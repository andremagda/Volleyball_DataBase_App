<?php
require_once "../db_connect.php";

// Initialize location_id from GET or POST
$location_id = isset($_POST['location_id']) ? $_POST['location_id'] : (isset($_GET['location_id']) ? $_GET['location_id'] : null);

// Handle prompt form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prompt_location_id'])) {
    $location_id = $_POST['prompt_location_id'];
}

// Handle location update submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['location_name'])) {
    $location_name = $_POST['location_name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $postal_code = $_POST['postal_code'];
    $web_address = $_POST['web_address'];
    $max_capacity = $_POST['max_capacity'];
    $location_type = $_POST['location_type'];
    $phone_number = $_POST['phone_number'];

    $query = "UPDATE Locations SET
              location_name = ?,
              address = ?,
              city = ?,
              province = ?,
              postal_code = ?,
              web_address = ?,
              max_capacity = ?,
              location_type = ?,
              phone_number = ?
              WHERE location_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssissi", $location_name, $address, $city, $province, $postal_code, $web_address, $max_capacity, $location_type, $phone_number, $location_id);

    if ($stmt->execute()) {
        $success_message = "Location updated successfully!";
    } else {
        $error_message = "Error updating location: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch location data if location_id is provided
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
    <title>Edit Location</title>
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
<h1>Volleyball Club</h1>
<section class="form-section">
    
    <h2>Edit Location</h2>

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
        <form method="post" action="edit_locations.php">
            <label for="prompt_location_id">Enter Location ID to Edit:</label>
            <input type="number" name="prompt_location_id" required>
            <input type="submit" value="Load Location">
        </form>
    <?php elseif ($location): ?>
        <!-- Edit form for the selected location -->
        <form method="post" action="edit_locations.php">
            <input type="hidden" name="location_id" value="<?php echo htmlspecialchars($location['location_id']); ?>">

            <label for="location_name">Location Name:</label>
            <input type="text" name="location_name" value="<?php echo htmlspecialchars($location['location_name']); ?>">
            <br><br>

            <label for="address">Address:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($location['address']); ?>">
            <br><br>

            <label for="city">City:</label>
            <input type="text" name="city" value="<?php echo htmlspecialchars($location['city']); ?>">
            <br><br>

            <label for="province">Province:</label>
            <input type="text" name="province" value="<?php echo htmlspecialchars($location['province']); ?>">
            <br><br>

            <label for="postal_code">Postal Code:</label>
            <input type="text" name="postal_code" maxlength="7" value="<?php echo htmlspecialchars($location['postal_code']); ?>">
            <br><br>

            <label for="web_address">Web Address:</label>
            <input type="text" name="web_address" value="<?php echo htmlspecialchars($location['web_address']); ?>">
            <br><br>

            <label for="max_capacity">Max Capacity:</label>
            <input type="number" name="max_capacity" value="<?php echo htmlspecialchars($location['max_capacity']); ?>">
            <br><br>

            <label for="location_type">Location Type:</label>
            <select name="location_type">
                <option value="head" <?php echo $location['location_type'] === 'head' ? 'selected' : ''; ?>>Head</option>
                <option value="branch" <?php echo $location['location_type'] === 'branch' ? 'selected' : ''; ?>>Branch</option>
            </select>
            <br><br>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" maxlength="15" value="<?php echo htmlspecialchars($location['phone_number']); ?>">
            <br><br>

            <input type="submit" value="Update Location">
        </form>
    <?php endif; ?>

    <p><a href="../locations/display_locations.php">Back to Locations List</a></p>

</body>
</html>
