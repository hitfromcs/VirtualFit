<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "virtualfit";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . mysqli_error($conn));
}
?>
