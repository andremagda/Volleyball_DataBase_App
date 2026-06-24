<?php
require_once "../db_connect.php";

// Query to fetch all personnel
$query = "SELECT * FROM Personnel";
$result = $conn->query($query);

if (!$result) {
    $error_message = "Error fetching personnel: " . $conn->error;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Personnel</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .error {
            padding: 10px;
            margin: 10px 0;
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
<h1>Volleyball Club</h1>
<section class="display-section">

    <h2>Personnel List</h2>

    <?php
    if (isset($error_message)) {
        echo "<div class='error'>$error_message</div>";
    }
    ?>

    <?php if ($result && $result->num_rows > 0): ?>
        <div class="table-container">
        <table>
            <tr>
                <th>Personnel ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of Birth</th>
                <th>SSN</th>
                <th>Medicare</th>
                <th>Telephone Number</th>
                <th>Address</th>
                <th>City</th>
                <th>Province</th>
                <th>Postal Code</th>
                <th>Email</th>
                <th>Mandate</th>
                <th>Working Role</th>
            </tr>
        </div>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['personnel_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['date_of_birth']); ?></td>
                    <td><?php echo htmlspecialchars($row['ssn']); ?></td>
                    <td><?php echo htmlspecialchars($row['medicare']); ?></td>
                    <td><?php echo htmlspecialchars($row['telephone_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['city']); ?></td>
                    <td><?php echo htmlspecialchars($row['province']); ?></td>
                    <td><?php echo htmlspecialchars($row['postal_code']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['mandate']); ?></td>
                    <td><?php echo htmlspecialchars($row['working_role']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
		<p>No personnel found in the database.</p>
    <?php endif; ?>

    <div class="action-buttons">
    <a href="create_personnel.php" class="btn">Add New Personnel</a>
    <a href="../main.php" class="btn">Back to Main Page</a>
    </div>

    </section>
</body>
</html>

<?php
// Free the result set if it exists
if ($result) {
    $result->free();
}
// Note: We don’t close $conn here since main.php manages it
?>

