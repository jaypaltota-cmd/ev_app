<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ev"; // your database name

$conn = new mysqli($host, $user, $pass, $dbname);

if($conn->connect_error){
    die("Database Connection Failed: " . $conn->connect_error);
}
// echo "DB Connected";  // Keep commented
?>
