<?php
$servername = "devapi.tirta-group.com";
$username = "test_db";
$password = "kV*f9VGxZZKxamk!";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>