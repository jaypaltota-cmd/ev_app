<?php
include("../config/config.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Charging Stations</title>
</head>
<body>

<h2>Verified Charging Stations</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Station Name</th>
        <th>Location</th>
        <th>Latitude</th>
        <th>Longitude</th>
    </tr>

<?php
$sql = "SELECT * FROM stations WHERE status='verified'";
$result = $conn->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "<tr>
                <td>".$row['station_name']."</td>
                <td>".$row['location']."</td>
                <td>".$row['latitude']."</td>
                <td>".$row['longitude']."</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No stations found</td></tr>";
}
?>

</table>

</body>
</html>
