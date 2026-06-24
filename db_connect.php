<?php
$conn = new mysqli("127.0.0.1", "root", "kkk3027.", "volleyball_club", 3306);

if ($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);
}
?>