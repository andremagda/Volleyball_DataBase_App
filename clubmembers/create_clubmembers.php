<?php
require_once "../db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $ssn = $_POST['ssn'];
    $telephone_number = $_POST['telephone_number'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $postal_code = $_POST['postal_code'];
    $gender = $_POST['gender'];
    $teams_id = $_POST['teams_id'] ?: null;
    $status = $_POST['status'];
    $medicare = $_POST['medicare'];
    $email = $_POST['email'];
    $deactivation_date = $_POST['deactivation_date'] ?: null;

    // Prepare SQL query to insert data into Clubmembers table
    $query = "INSERT INTO Clubmembers (first_name, last_name, date_of_birth, height, weight, ssn, telephone_number, address, city, province, postal_code, gender, teams_id, status, medicare, email, deactivation_date)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Bind parameters to the query
    $stmt->bind_param("sssiiisssssssissi",
        $first_name,
        $last_name,
        $date_of_birth,
        $height,
        $weight,
        $ssn,
        $telephone_number,
        $address,
        $city,
        $province,
        $postal_code,
        $gender,
        $teams_id,
        $status,
        $medicare,
        $email,
        $deactivation_date
    );

    // Execute the query and handle the result
    if ($stmt->execute()) {
        $success_message = "Club member added successfully!";
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
    <title>Add Club Member</title>
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
    <h2>Create a New Club Member</h2><br>

    <?php
    if (isset($success_message)) {
        echo "<div class='message success'>$success_message</div>";
    }
    if (isset($error_message)) {
        echo "<div class='message error'>$error_message</div>";
    }
    ?>

    <form method="post" action="create_clubmember.php">
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
        <label for="height">Height (cm):</label>
        <input type="number" name="height">
        </div>

        <div class="form-row">
        <label for="weight">Weight (kg):</label>
        <input type="number" name="weight">
        </div>

        <div class="form-row">
        <label for="ssn">SSN:</label>
        <input type="text" name="ssn" maxlength="15" required>
        </div>

        <div class="form-row">
        <label for="telephone_number">Telephone:</label>
        <input type="text" name="telephone_number" maxlength="15">
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
        <input type="text" name="postal_code" maxlength="7">
        </div>

        <div class="form-row">
        <label for="gender">Gender:</label>
        <select name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
        </div>

        <div class="form-row">
        <label for="teams_id">Team ID:</label>
        <input type="number" name="teams_id">
        </div>

        <div class="form-row">
        <label for="status">Status:</label>
        <select name="status">
            <option value="active">Active</option>
            <option value="inactive" selected>Inactive</option>
        </select>
        </div>

        <div class="form-row">
        <label for="medicare">Medicare:</label>
        <input type="text" name="medicare" maxlength="15" required>
        </div>

        <div class="form-row">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        </div>

        <div class="form-row">
        <label for="deactivation_date">Deactivation Date:</label>
        <input type="date" name="deactivation_date">
        </div>

        <input type="submit" value="Add Club Member" class="submit-btn">
        <a href="../main.php" class="back-btn">Back to Main Page</a>
    </form>
</section>
</body>
</html>

<?php
// Connection will be closed in main.php if needed
?>
