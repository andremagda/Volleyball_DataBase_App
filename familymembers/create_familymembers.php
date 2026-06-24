<?php
require_once "../db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $ssn = $_POST['ssn'];
    $telephone_number = $_POST['telephone_number'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $postal_code = $_POST['postal_code'];
    $email = $_POST['email'];
    $medicare = $_POST['medicare'];
    $familymember2_id = $_POST['familymember2_id'] ?: null;

    // Prepare SQL query to insert data into Familymembers table
    $query = "INSERT INTO Familymembers (first_name, last_name, date_of_birth, ssn, telephone_number, address, city, province, postal_code, email, medicare, familymember2_id)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Bind parameters to the query
    $stmt->bind_param("sssssssssssi",
        $first_name,
        $last_name,
        $date_of_birth,
        $ssn,
        $telephone_number,
        $address,
        $city,
        $province,
        $postal_code,
        $email,
        $medicare,
        $familymember2_id
    );

    // Execute the query and handle the result
    if ($stmt->execute()) {
        $success_message = "Family member added successfully!";
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
    <title>Add Family Member</title>
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

    <h2>Create a New Family Member</h2><br>

    <?php
    if (isset($success_message)) {
        echo "<div class='message success'>$success_message</div>";
    }
    if (isset($error_message)) {
        echo "<div class='message error'>$error_message</div>";
    }
    ?>

    <form method="post" action="create_familymembers.php">
        <div class="form-row">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name">
        </div>

        <div class="form-row">
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name">
        </div>

        <div class="form-row">
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" name="date_of_birth">
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
        <label for="email">Email:</label>
        <input type="email" name="email">
        </div>


        <div class="form-row">
        <label for="medicare">Medicare:</label>
        <input type="text" name="medicare" maxlength="15" required>
        </div>

        <div class="form-row">
        <label for="familymember2_id">Related Family Member ID:</label>
        <input type="number" name="familymember2_id">
        </div>

        <input type="submit" value="Add Family Member" class="submit-btn">
        <a href="../main.php" class="back-btn">Back to Main Page</a>

    </form>
</body>
</html>

<?php
// Connection will be closed in main.php if needed
?>

