<?php
require_once "../config/db.php";

$id = $_GET['id'];

$conn->query("UPDATE owners SET verified = 1 WHERE id = $id");

header("Location: dashboard.php");
exit;
