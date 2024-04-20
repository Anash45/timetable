<?php
// Database credentials

$servername = "localhost";
$username = "u956940883_timetable";
$password = ";VGesS/4";
$database = "u956940883_timetable";

// // Database credentials
// $servername = "localhost";
// $username = "root";
// $password = "root";
// $database = "timetable_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
