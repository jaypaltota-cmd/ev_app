<?php
session_start();
include("../config/config.php");

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$sql = "UPDATE owners SET verified='approved' WHERE id=$id";

$conn->query($sql);

header("Location: dashboard.php");
exit;
?>
