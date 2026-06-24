<?php
require_once "../db_connect.php";

// Initialize clubmember_id from GET or POST
$clubmember_id = isset($_POST['clubmember_id']) ? $_POST['clubmember_id'] : (isset($_GET['clubmember_id']) ? $_GET['clubmember_id'] : null);

// Handle prompt form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prompt_clubmember_id'])) {
    $clubmember_id = $_POST['prompt_clubmember_id'];
}

// Handle club member update submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['first_name'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $height = $_POST['height'] ?: null;
    $weight = $_POST['weight'] ?: null;
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

    $query = "UPDATE Clubmembers SET
              first_name = ?,
              last_name = ?,
              date_of_birth = ?,
              height = ?,
              weight = ?,
              ssn = ?,
              telephone_number = ?,
              address = ?,
              city = ?,
              province = ?,
              postal_code = ?,
              gender = ?,
              teams_id = ?,
              status = ?,
              medicare = ?,
              email = ?,
              deactivation_date = ?
              WHERE clubmember_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssiiissssssisissi",
        $first_name, $last_name, $date_of_birth, $height, $weight, $ssn, $telephone_number,
        $address, $city, $province, $postal_code, $gender, $teams_id, $status, $medicare, $email, $deactivation_date, $clubmember_id
    );

    if ($stmt->execute()) {
        $success_message = "Club member updated successfully!";
    } else {
        $error_message = "Error updating club member: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch club member data if clubmember_id is provided
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
    <title>Edit Club Member</title>
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

    <h2>Edit Club Member</h2>

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
        <form method="post" action="update_clubmembers.php">
            <label for="prompt_clubmember_id">Enter Club Member ID to Edit:</label>
            <input type="number" name="prompt_clubmember_id" required>
            <input type="submit" value="Load Club Member" class="load-btn">
        </form>
    <?php elseif ($club_member): ?>
        <!-- Edit form for the selected club member -->
        <form method="post" action="update_clubmembers.php">

            <input type="hidden" name="clubmember_id" value="<?php echo htmlspecialchars($club_member['clubmember_id']); ?>">

            <div class="form-row">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($club_member['first_name']); ?>">
            </div>

            <div class="form-row">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($club_member['last_name']); ?>">
            </div>

            <div class="form-row">
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($club_member['date_of_birth']); ?>">
            </div>

            <div class="form-row">
            <label for="height">Height (cm):</label>
            <input type="number" name="height" value="<?php echo htmlspecialchars($club_member['height']); ?>">
            </div>

            <div class="form-row">
            <label for="weight">Weight (kg):</label>
            <input type="number" name="weight" value="<?php echo htmlspecialchars($club_member['weight']); ?>">
            </div>

            <div class="form-row">
            <label for="ssn">SSN:</label>
            <input type="text" name="ssn" maxlength="15" value="<?php echo htmlspecialchars($club_member['ssn']); ?>" required>
            </div>

            <div class="form-row">
            <label for="telephone_number">Telephone Number:</label>
            <input type="text" name="telephone_number" maxlength="15" value="<?php echo htmlspecialchars($club_member['telephone_number']); ?>">
            </div>

            <div class="form-row">
            <label for="address">Address:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($club_member['address']); ?>">
            </div>

            <div class="form-row">
            <label for="city">City:</label>
            <input type="text" name="city" value="<?php echo htmlspecialchars($club_member['city']); ?>">
            </div>

            <div class="form-row">
            <label for="province">Province:</label>
            <input type="text" name="province" value="<?php echo htmlspecialchars($club_member['province']); ?>">
            </div>

            <div class="form-row">
            <label for="postal_code">Postal Code:</label>
            <input type="text" name="postal_code" maxlength="7" value="<?php echo htmlspecialchars($club_member['postal_code']); ?>">
            </div>

            <div class="form-row">
            <label for="gender">Gender:</label>
            <select name="gender">
                <option value="male" <?php echo $club_member['gender'] === 'male' ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo $club_member['gender'] === 'female' ? 'selected' : ''; ?>>Female</option>
            </select>
            </div>

            <div class="form-row">
            <label for="teams_id">Team ID:</label>
            <input type="number" name="teams_id" value="<?php echo htmlspecialchars($club_member['teams_id']); ?>">
            </div>

            <div class="form-row">
            <label for="status">Status:</label>
            <select name="status">
                <option value="active" <?php echo $club_member['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?php echo $club_member['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
            </select>
            </div>

            <div class="form-row">
            <label for="medicare">Medicare:</label>
            <input type="text" name="medicare" maxlength="15" value="<?php echo htmlspecialchars($club_member['medicare']); ?>" required>
            </div>

            <div class="form-row">
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($club_member['email']); ?>" required>
            </div>

            <div class="form-row">
            <label for="deactivation_date">Deactivation Date:</label>
            <input type="date" name="deactivation_date" value="<?php echo htmlspecialchars($club_member['deactivation_date']); ?>">
            </div>

            <input type="submit" value="Update Club Member" class="load-btn">
        </form>
    <?php endif; ?>

     <div class="button-row">
        <a href="view_clubmembers.php" class="btn">Club Members List</a>
        <a href="../main.php" class="btn">Back to Main Page</a>
    </div>
    </section>
</body>
</html>

