<!DOCTYPE html>
<html>
<head>
    <title>Battery Range Calculator</title>
</head>
<body>

<h2>Battery Range Calculator</h2>

<form method="post">
    Enter Battery %: <input type="number" name="battery" required>
    <button type="submit">Check Range</button>
</form>

<?php
if(isset($_POST['battery'])){
    $battery = $_POST['battery'];
    $maxRange = 300; // assume 100% = 300 km
    $range = ($battery/100) * $maxRange;

    echo "<h3>Your Estimated Range: " . round($range) . " km</h3>";
}
?>

</body>
</html>
