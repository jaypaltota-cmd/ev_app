<?php
session_start();
include("../config/config.php");

if(!isset($_SESSION['owner_id'])){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

$sql = "SELECT * FROM stations WHERE id=$id";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

if(isset($_POST['update'])){
    $name = $_POST['station_name'];
    $location = $_POST['location'];
    $lat = $_POST['latitude'];
    $lng = $_POST['longitude'];

    $update = "UPDATE stations SET 
                station_name='$name',
                location='$location',
                latitude='$lat',
                longitude='$lng'
               WHERE id=$id";

    if($conn->query($update)){
        echo "<h3>Updated Successfully!</h3>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Station</title>
</head>
<body>

<h2>Edit Station</h2>

<form method="post">
    <label>Station Name:</label><br>
    <input type="text" name="station_name" value="<?php echo $data['station_name']; ?>" required><br><br>

    <label>Location:</label><br>
    <input type="text" name="location" value="<?php echo $data['location']; ?>" required><br><br>

    <label>Latitude:</label><br>
    <input type="text" name="latitude" value="<?php echo $data['latitude']; ?>" required><br><br>

    <label>Longitude:</label><br>
    <input type="text" name="longitude" value="<?php echo $data['longitude']; ?>" required><br><br>

    <button type="submit" name="update">Update</button>
</form>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
