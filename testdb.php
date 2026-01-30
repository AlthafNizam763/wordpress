<?php
$servername = "localhost";
$username = "wp_user";
$password = "StrongPass123";
$dbname = "wordpress_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
