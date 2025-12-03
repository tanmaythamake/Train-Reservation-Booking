<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "train_db"; // Change if your DB name is different

$conn = new mysqli($servername, $username, $password, $dbname);

// Check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
