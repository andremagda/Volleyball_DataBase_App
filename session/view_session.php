<?php
require_once "../db_connect.php";

// Query to fetch all sessions
$query = "SELECT * FROM Session";
$result = $conn->query($query);

if (!$result) {
    $error_message = "Error fetching sessions: " . $conn->error;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Sessions</title>
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
    <h2>Volleyball Club Sessions</h2>

    <?php
    if (isset($error_message)) {
        echo "<div class='error'>$error_message</div>";
    }
    ?>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Session ID</th>
                <th>Team ID</th>
                <th>Session Type</th>
                <th>Session Date</th>
                <th>Session Time</th>
                <th>Session Address</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['session_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['teams_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['session_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['session_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['session_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['session_address']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No sessions found in the database.</p>
    <?php endif; ?>

    <p><a href="create_session.php">Add New Session</a></p>
    <p><a href="../main.php">Back to Main Page</a></p>

</body>
</html>

<?php
// Free the result set if it exists
if ($result) {
    $result->free();
}
// Note: We don’t close $conn here since main.php manages it
?>


