<?php
require_once "../db_connect.php";

// Query to fetch all club members
$query = "SELECT * FROM Clubmembers";
$result = $conn->query($query);

if (!$result) {
    $error_message = "Error fetching club members: " . $conn->error;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Club Members</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        table {
            border-collapse: collapse;
            width: 85%;
            margin: 30px;
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

    <h2>Club Members</h2>
    <?php
    if (isset($error_message)) {
        echo "<div class='error'>$error_message</div>";
    }
    ?>

    <?php if ($result && $result->num_rows > 0): ?>
        <div class="table-container">
        <table>
            <tr>
                <th>Member ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of Birth</th>
                <th>Height</th>
                <th>Weight</th>
                <th>SSN</th>
                <th>Telephone</th>
                <th>Address</th>
                <th>City</th>
                <th>Province</th>
                <th>Postal Code</th>
                <th>Gender</th>
                <th>Team ID</th>
                <th>Status</th>
                <th>Medicare</th>
                <th>Email</th>
                <th>Deactivation Date</th>
            </tr>
            </div>

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['clubmember_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['date_of_birth']); ?></td>
                    <td><?php echo htmlspecialchars($row['height']); ?></td>
                    <td><?php echo htmlspecialchars($row['weight']); ?></td>
                    <td><?php echo htmlspecialchars($row['ssn']); ?></td>
                    <td><?php echo htmlspecialchars($row['telephone_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['city']); ?></td>
                    <td><?php echo htmlspecialchars($row['province']); ?></td>
                    <td><?php echo htmlspecialchars($row['postal_code']); ?></td>
                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                    <td><?php echo htmlspecialchars($row['teams_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo htmlspecialchars($row['medicare']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['deactivation_date']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No club members found in the database.</p>
    <?php endif; ?>

    <div class="action-buttons">
    <a href="create_clubmembers.php" class="btn">Add New Club Member</a>
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
