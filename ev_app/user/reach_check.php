<?php
session_start();

// If user is not logged in → redirect
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Destination Reachability Check</title>
</head>
<body>

<h2>📍 Destination Feasibility Checker</h2>

<form method="POST">
    <label>Current Battery (%) :</label><br>
    <input type="number" name="battery" min="1" max="100" required><br><br>

    <label>Full Battery Range (km):</label><br>
    <input type="number" name="full_range" placeholder="Example: 300" required><br><br>

    <label>Distance to Destination (km):</label><br>
    <input type="number" name="distance" required><br><br>

    <button type="submit">Check</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $battery = $_POST['battery'];
    $full_range = $_POST['full_range'];
    $distance = $_POST['distance'];

    // Calculate available range
    $available_range = ($battery / 100) * $full_range;

    echo "<h3>Available Range: <strong>".round($available_range)." km</strong></h3>";

    if ($available_range >= $distance) {
        echo "<h2 style='color:green;'>✔ You can reach your destination!</h2>";
    } else {
        echo "<h2 style='color:red;'>❌ Charging Required Before Trip</h2>";
    }
}
?>

<br><br>
<a href="dashboard.php">⬅ Back to Dashboard</a>

</body>
</html>
