<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "login";
// Use the correct port, or exclude it for default
$port = "3306"; // Optional, remove if using default port

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Debugging: Check if connection is established
// echo "Connected successfully!";
?>
