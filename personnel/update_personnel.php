<?php
require_once "../db_connect.php";

// Initialize personnel_id from GET or POST
$personnel_id = isset($_POST['personnel_id']) ? $_POST['personnel_id'] : (isset($_GET['personnel_id']) ? $_GET['personnel_id'] : null);

// Handle prompt form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prompt_personnel_id'])) {
    $personnel_id = $_POST['prompt_personnel_id'];
}

// Handle personnel update submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['first_name'])) {
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

    $query = "UPDATE Personnel SET
              first_name = ?,
              last_name = ?,
              date_of_birth = ?,
              ssn = ?,
              medicare = ?,
              telephone_number = ?,
              address = ?,
              city = ?,
              province = ?,
              postal_code = ?,
              email = ?,
              mandate = ?,
              working_role = ?
              WHERE personnel_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssssssssi",
        $first_name, $last_name, $date_of_birth, $ssn, $medicare, $telephone_number,
        $address, $city, $province, $postal_code, $email, $mandate, $working_role, $personnel_id
    );

    if ($stmt->execute()) {
        $success_message = "Personnel updated successfully!";
    } else {
        $error_message = "Error updating personnel: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch personnel data if personnel_id is provided
$personnel = null;
if ($personnel_id) {
    $query = "SELECT * FROM Personnel WHERE personnel_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $personnel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $personnel = $result->fetch_assoc();

    if (!$personnel) {
        $error_message = "Personnel with ID $personnel_id not found.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Personnel</title>
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
    
    <h2>Edit Personnel</h2>

    <?php
    if (isset($success_message)) {
        echo "<div class='message success'>$success_message</div>";
    }
    if (isset($error_message)) {
        echo "<div class='message error'>$error_message</div>";
    }
    ?>

    <?php if (!$personnel_id): ?>
        <!-- Prompt form to enter personnel_id -->
        <form method="post" action="update_personnel.php">
            <label for="prompt_personnel_id">Enter Personnel ID to Edit:</label>
            <input type="number" name="prompt_personnel_id" required>
            <input type="submit" value="Load Personnel" class="load-btn">
        </form>
    <?php elseif ($personnel): ?>
        <!-- Edit form for the selected personnel -->
        <form method="post" action="update_personnel.php">
            <input type="hidden" name="personnel_id" value="<?php echo htmlspecialchars($personnel['personnel_id']); ?>">

            <div class="form-row">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?php echo htmlspecialchars($personnel['first_name']); ?>">
            </div>

            <div class="form-row">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?php echo htmlspecialchars($personnel['last_name']); ?>">
            </div>

            <div class="form-row">
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($personnel['date_of_birth']); ?>">
            </div>

            <div class="form-row">
            <label for="ssn">SSN:</label>
            <input type="text" name="ssn" maxlength="15" value="<?php echo htmlspecialchars($personnel['ssn']); ?>" required>
            </div>

            <div class="form-row">
            <label for="medicare">Medicare:</label>
            <input type="text" name="medicare" maxlength="15" value="<?php echo htmlspecialchars($personnel['medicare']); ?>" required>
            </div>

            <div class="form-row">
            <label for="telephone_number">Telephone Number:</label>
            <input type="text" name="telephone_number" maxlength="15" value="<?php echo htmlspecialchars($personnel['telephone_number']); ?>">
            </div>

            <div class="form-row">
            <label for="address">Address:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($personnel['address']); ?>">
            </div>

            <div class="form-row">
            <label for="city">City:</label>
            <input type="text" name="city" value="<?php echo htmlspecialchars($personnel['city']); ?>">
            </div>

            <div class="form-row">
            <label for="province">Province:</label>
            <input type="text" name="province" value="<?php echo htmlspecialchars($personnel['province']); ?>">
            </div>

            <div class="form-row">
            <label for="postal_code">Postal Code:</label>
            <input type="text" name="postal_code" maxlength="7" value="<?php echo htmlspecialchars($personnel['postal_code']); ?>">
            </div>

            <div class="form-row">
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($personnel['email']); ?>">
            </div>

            <div class="form-row">
            <label for="mandate">Mandate:</label>
            <select name="mandate">
                <option value="volunteer" <?php echo $personnel['mandate'] === 'volunteer' ? 'selected' : ''; ?>>Volunteer</option>
                <option value="salaried" <?php echo $personnel['mandate'] === 'salaried' ? 'selected' : ''; ?>>Salaried</option>
            </select>
            </div>

            <div class="form-row">
            <label for="working_role">Working Role:</label>
            <select name="working_role">
                <option value="administrator" <?php echo $personnel['working_role'] === 'administrator' ? 'selected' : ''; ?>>Administrator</option>
                <option value="captain" <?php echo $personnel['working_role'] === 'captain' ? 'selected' : ''; ?>>Captain</option>
                <option value="coach" <?php echo $personnel['working_role'] === 'coach' ? 'selected' : ''; ?>>Coach</option>
                <option value="assistant coach" <?php echo $personnel['working_role'] === 'assistant coach' ? 'selected' : ''; ?>>Assistant Coach</option>
                <option value="treasurer" <?php echo $personnel['working_role'] === 'treasurer' ? 'selected' : ''; ?>>Treasurer</option>
                <option value="secretary" <?php echo $personnel['working_role'] === 'secretary' ? 'selected' : ''; ?>>Secretary</option>
                <option value="general manager" <?php echo $personnel['working_role'] === 'general manager' ? 'selected' : ''; ?>>General Manager</option>
                <option value="deputy manager" <?php echo $personnel['working_role'] === 'deputy manager' ? 'selected' : ''; ?>>Deputy Manager</option>
                <option value="manager" <?php echo $personnel['working_role'] === 'manager' ? 'selected' : ''; ?>>Manager</option>
                <option value="other" <?php echo $personnel['working_role'] === 'other' ? 'selected' : ''; ?>>Other</option>
            </select>
            </div>

            <input type="submit" value="Update Personnel" class="load-btn">
        </form>
    <?php endif; ?>

     <div class="button-row">
        <a href="../personnel/view_personnel.php" class="btn">Back to Personnel List</a>
        <a href="../main.php" class="btn">Back to Main Page</a>
    </div>
    </section>

</body>
</html>

