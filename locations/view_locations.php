<?php
require_once "../db_connect.php";


// Query to fetch all locations
$query = "SELECT * FROM Locations";
$result = $conn->query($query);

if (!$result) {
    $error_message = "Error fetching locations: " . $conn->error;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Locations</title>
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

    <h2>Volleyball Club Locations</h2>

    <?php
    if (isset($error_message)) {
        echo "<div class='error'>$error_message</div>";
    }
    ?>

    <?php if ($result && $result->num_rows > 0): ?>
        <div class="table-container">
        <table>
            <tr>
				<th>Location ID</th>
                <th>Location Name</th>
                <th>Address</th>
                <th>City</th>
                <th>Province</th>
                <th>Postal Code</th>
                <th>Web Address</th>
                <th>Max Capacity</th>
                <th>Location Type</th>
                <th>Phone Number</th>
            </tr>
        </div>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
					<td><?php echo htmlspecialchars($row['location_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['location_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['city']); ?></td>
                    <td><?php echo htmlspecialchars($row['province']); ?></td>
                    <td><?php echo htmlspecialchars($row['postal_code']); ?></td>
                    <td><?php echo htmlspecialchars($row['web_address']); ?></td>
                    <td><?php echo htmlspecialchars($row['max_capacity']); ?></td>
                    <td><?php echo htmlspecialchars($row['location_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No locations found in the database.</p>
    <?php endif; ?>

    <div class="action-buttons">
    <a href="create_locations.php" class="btn">Add New Location</a>
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

