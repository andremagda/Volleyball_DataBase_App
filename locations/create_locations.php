<?php
require_once "../db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $location_name = $_POST['location_name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $postal_code = $_POST['postal_code'];
    $web_address = $_POST['web_address'];
    $max_capacity = $_POST['max_capacity'];
    $location_type = $_POST['location_type'];
    $phone_number = $_POST['phone_number'];

    // Prepare SQL query to insert data into Locations table
    $query = "INSERT INTO Locations (location_name, address, city, province, postal_code, web_address, max_capacity, location_type, phone_number)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Bind parameters to the query
    $stmt->bind_param("ssssssiss", $location_name, $address, $city, $province, $postal_code, $web_address, $max_capacity, $location_type, $phone_number);

	// Execute the query and handle the result
	if ($stmt->execute()) {
		$success_message = "Location added successfully!";
	} else {
		$error_message = "Error: " . $stmt->error;
	}
    // Close the statement and connection
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Location</title>
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

    <h2>Create a New Location</h2><br>

	<?php
    // Display success or error message if it exists
    if (isset($success_message)) {
        echo "<div class='message success'>$success_message</div>";
    }
    if (isset($error_message)) {
        echo "<div class='message error'>$error_message</div>";
    }
    ?>

    <form method="post" action="create_locations.php">
        <div class="form-row">
        <label for="location_name">Location Name:</label>
        <input type="text" name="location_name" required>
        </div>

        <div class="form-row">
        <label for="address">Address:</label>
        <input type="text" name="address" required>
        </div>

        <div class="form-row">
        <label for="city">City:</label>
        <input type="text" name="city">
        </div>

        <div class="form-row">
        <label for="province">Province:</label>
        <input type="text" name="province">
        </div>

        <div class="form-row">
        <label for="postal_code">Postal Code:</label>
        <input type="text" name="postal_code">
        </div>

        <div class="form-row">
        <label for="web_address">Web Address:</label>
        <input type="text" name="web_address">
        </div>

        <div class="form-row">
        <label for="max_capacity">Max Capacity:</label>
        <input type="number" name="max_capacity">
        </div>

        <div class="form-row">
        <label for="location_type">Location Type:</label>
        <select name="location_type">
            <option value="head">Head</option>
            <option value="branch">Branch</option>
        </select>
        </div>

        <div class="form-row">
        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number">
        </div>

        <input type="submit" value="Add Location" class="submit-btn">
        <a href="../main.php" class="back-btn">Back to Main Page</a>

    </form>
</body>
</html>

<?php
// Connection will be closed in main.php if needed
?>
