<?php
$host = "localhost";
$user = "root";
$pass = "";  // XAMPP default: empty password
$dbname = "ev"; // your database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
