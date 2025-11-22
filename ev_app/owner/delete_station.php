<?php
session_start();
include("../config/config.php");

if(!isset($_SESSION['owner_id'])){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$sql = "DELETE FROM stations WHERE id=$id";

$conn->query($sql);

header("Location: dashboard.php");
exit;
?>
