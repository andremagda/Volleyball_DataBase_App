<?php
require_once "../db_connect.php";

// Initialize familymember_id from GET or POST
$familymember_id = isset($_POST['familymember_id']) ? $_POST['familymember_id'] : (isset($_GET['familymember_id']) ? $_GET['familymember_id'] : null);

// Handle prompt form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prompt_familymember_id'])) {
    $familymember_id = $_POST['prompt_familymember_id'];
}

// Handle family member update submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['first_name'])) {
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

    $query = "UPDATE Familymembers SET
              first_name = ?,
              last_name = ?,
              date_of_birth = ?,
              ssn = ?,
              telephone_number = ?,
              address = ?,
              city = ?,
              province = ?,
              postal_code = ?,
              email = ?,
              medicare = ?,
              familymember2_id = ?
              WHERE familymember_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssssssi",
        $first_name, $last_name, $date_of_birth, $ssn, $telephone_number,
        $address, $city, $province, $postal_code, $email, $medicare, $familymember2_id, $familymember_id
    );

    if ($stmt->execute()) {
        $success_message = "Family member updated successfully!";
    } else {
        $error_message = "Error updating family member: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch family member data if familymember_id is provided
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
    <title>Edit Family Member</title>
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
<section class="update-section">

    <h2>Edit Family Member</h2>

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
        <form method="post" action="update_familymembers.php">
            <label for="prompt_familymember_id">Enter Family Member ID to Edit:</label>
            <input type="number" name="prompt_familymember_id" required>
            <input type="submit" value="Load Family Member" class="load-btn">
        </form>
    <?php elseif ($family_member): ?>
        <!-- Edit form for the selected family member -->
        <form method="post" action="update_familymembers.php">
            <input type="hidden" name="familymember_id" value="<?php echo htmlspecialchars($family_member['familymember_id']); ?>">

            <div class="form-row">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($family_member['first_name']); ?>">
            </div>

            <div class="form-row">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($family_member['last_name']); ?>">
            </div>

            <div class="form-row">
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($family_member['date_of_birth']); ?>">
            </div>

            <div class="form-row">
            <label for="ssn">SSN:</label>
            <input type="text" name="ssn" maxlength="15" value="<?php echo htmlspecialchars($family_member['ssn']); ?>" required>
            </div>

            <div class="form-row">
            <label for="telephone_number">Telephone Number:</label>
            <input type="text" name="telephone_number" maxlength="15" value="<?php echo htmlspecialchars($family_member['telephone_number']); ?>">
            </div>

            <div class="form-row">
            <label for="address">Address:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($family_member['address']); ?>">
            </div>

            <div class="form-row">
            <label for="city">City:</label>
            <input type="text" name="city" value="<?php echo htmlspecialchars($family_member['city']); ?>">
            </div>

            <div class="form-row">
            <label for="province">Province:</label>
            <input type="text" name="province" value="<?php echo htmlspecialchars($family_member['province']); ?>">
            </div>

            <div class="form-row">
            <label for="postal_code">Postal Code:</label>
            <input type="text" name="postal_code" maxlength="7" value="<?php echo htmlspecialchars($family_member['postal_code']); ?>">
            </div>

            <div class="form-row">
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($family_member['email']); ?>">
            </div>

            <div class="form-row">
            <label for="medicare">Medicare:</label>
            <input type="text" name="medicare" maxlength="15" value="<?php echo htmlspecialchars($family_member['medicare']); ?>" required>
            </div>

            <div class="form-row">
            <label for="familymember2_id">Related Family Member ID:</label>
            <input type="number" name="familymember2_id" value="<?php echo htmlspecialchars($family_member['familymember2_id']); ?>">
            </div>

            <input type="submit" value="Update Family Member" class="load-btn">
        </form>
    <?php endif; ?>

     <div class="button-row">
        <a href="../familymembers/display_familymembers.php" class="btn">Back to Family Members List</a>
        <a href="../main.php" class="btn">Back to Main Page</a>
    </div>
    </section>
</body>
</html>
