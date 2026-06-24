<?php
require_once "db_connect.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Volleyball Club Management System</title>
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

    <h1>Volleyball Club Management System</h1>
	<div class="container">

		<div class="section-card">
		<i class="fa-solid fa-address-card"></i>
    	<h2>Club Members</h2>
			<a href="clubmembers/view_clubmembers.php">View Club Members</a>
			<a href="clubmembers/create_clubmembers.php">Add Club Member</a>
			<a href="clubmembers/update_clubmembers.php">Update Club Member</a>
			<a href="clubmembers/delete_clubmembers.php">Delete Club Member</a>
		</div>

		<div class="section-card">
		<i class="fa-solid fa-people-roof"></i>
    	<h2>Family Members</h2>
			<a href="familymembers/view_familymembers.php">View Family Members</a>
			<a href="familymembers/create_familymembers.php">Add Family Member</a>
			<a href="familymembers/update_familymembers.php">Update Family Member</a>
			<a href="familymembers/delete_familymembers.php">Delete Family Member</a>
		</div>

		<div class="section-card">
		<i class="fa-solid fa-users"></i>
   	 	<h2>Personnel</h2>
			<a href="personnel/view_personnel.php">View Personnel</a>
			<a href="personnel/create_personnel.php">Add Personnel</a>
			<a href="personnel/update_personnel.php">Update Personnel</a>
			<a href="personnel/delete_personnel.php">Delete Personnel</a>
		</div>

		<div class="section-card">
		<i class="fa-solid fa-location-dot"></i>
    	<h2>Locations</h2>
			<a href="locations/view_locations.php">View Locations</a>
			<a href="locations/create_locations.php">Add Location</a>
			<a href="locations/update_locations.php">Update Location</a>
			<a href="locations/delete_locations.php">Delete Location</a>
		</div>

    <!-- <h2>Sessions</h2>
    <a href="session/view_session.php">View Sessions</a>
    <a href="session/create_session.php">Add Session</a>
	<a href="session/update_session.php">Update Session</a>
	<a href="session/delete_session.php">Delete Session</a> -->
	</div>
</body>
</html>