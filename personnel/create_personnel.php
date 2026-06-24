<?php
require_once "../db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $ssn = $_POST['ssn'];
    $medicare = $_POST['medicare'];
    $telephone_number = $_POST['telephone_number'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $postal_code = $_POST['postal_code'];
    $email = $_POST['email'];
    $mandate = $_POST['mandate'];
    $working_role = $_POST['working_role'];

    // Prepare SQL query to insert data into Personnel table
    $query = "INSERT INTO Personnel (first_name, last_name, date_of_birth, ssn, medicare, telephone_number, address, city, province, postal_code, email, mandate, working_role)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Bind parameters to the query
    $stmt->bind_param("sssssssssssss", $first_name, $last_name, $date_of_birth, $ssn, $medicare, $telephone_number, $address, $city, $province, $postal_code, $email, $mandate, $working_role);

	// Execute the query and handle the result
	if ($stmt->execute()) {
		$success_message = "Personnel added successfully!";
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
    <title>Add Personnel</title>
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
    <h2>Create a New Personnel</h2><br>

    <?php
    // Display success or error message if it exists
    if (isset($success_message)) {
        echo "<div class='message success'>$success_message</div>";
    }
    if (isset($error_message)) {
        echo "<div class='message error'>$error_message</div>";
    }
    ?>

    <form method="post" action="create_personnel.php">
        <div class="form-row">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" required>
        </div>

        <div class="form-row">
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required>
        </div>

        <div class="form-row">
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" name="date_of_birth">
        </div>

        <div class="form-row">
        <label for="ssn">SSN:</label>
        <input type="text" name="ssn" required>
        </div>

        <div class="form-row">
        <label for="medicare">Medicare:</label>
        <input type="text" name="medicare" required>
        </div>

        <div class="form-row">
        <label for="telephone_number">Telephone Number:</label>
        <input type="text" name="telephone_number">
        </div>

        <div class="form-row">
        <label for="address">Address:</label>
        <input type="text" name="address">
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
        <label for="email">Email:</label>
        <input type="email" name="email">
        </div>

        <div class="form-row">
        <label for="mandate">Mandate:</label>
        <select name="mandate">
            <option value="volunteer">Volunteer</option>
            <option value="salaried">Salaried</option>
        </select>
        </div>

        <div class="form-row">
        <label for="working_role">Working Role:</label>
        <select name="working_role">
            <option value="administrator">Administrator</option>
            <option value="captain">Captain</option>
            <option value="coach">Coach</option>
            <option value="assistant coach">Assistant Coach</option>
            <option value="treasurer">Treasurer</option>
            <option value="secretary">Secretary</option>
            <option value="general manager">General Manager</option>
            <option value="deputy manager">Deputy Manager</option>
            <option value="manager">Manager</option>
            <option value="other">Other</option>
        </select>
        </div>

        <input type="submit" value="Add Personnel" class="submit-btn">
        <a href="../main.php" class="back-btn">Back to Main Page</a>

    </form>
</body>
</html>

<?php
// Connection will be closed in main.php if needed
?>

