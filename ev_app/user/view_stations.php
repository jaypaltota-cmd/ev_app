<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include("../config/db.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Charging Stations</title>
</head>
<body>

<h2>⚡ Verified Charging Stations</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Station Name</th>
        <th>Location</th>
        <th>Charger Type</th>
        <th>Status</th>
    </tr>

<?php
$sql = "SELECT * FROM stations WHERE status='Verified'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['station_name']."</td>
                <td>".$row['location']."</td>
                <td>".$row['charger_type']."</td>
                <td>".$row['status']."</td>
              </tr>";
    }

} else {
    echo "<tr><td colspan='5'>No verified stations found.</td></tr>";
}
?>

</table>

<br><br>
<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
