<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['owner_id'])){
    header("Location: login.php");
    exit;
}

$owner_id = $_SESSION['owner_id'];
$owner_name = $_SESSION['owner_name'];

// Fetch stations
$sql = "SELECT * FROM stations WHERE owner_id=$owner_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Owner Dashboard | EV Charge Hub</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
<style>
    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: #0f172a;
        color: white;
    }

    .sidebar {
        width: 250px;
        height: 100vh;
        background: #1e293b;
        position: fixed;
        left: 0;
        top: 0;
        padding: 30px;
    }

    .sidebar h2 {
        margin-bottom: 30px;
        font-size: 22px;
        text-align: center;
        color: #38bdf8;
    }

    .sidebar a {
        display: block;
        padding: 12px;
        margin: 8px 0;
        color: white;
        text-decoration: none;
        background: #334155;
        border-radius: 6px;
        transition: .3s;
    }

    .sidebar a:hover {
        background: #38bdf8;
        color: #0f172a;
    }

    .content {
        margin-left: 270px;
        padding: 30px;
    }

    h1 {
        font-size: 28px;
        margin-bottom: 15px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
        background: #1e293b;
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 14px;
        text-align: left;
    }

    th {
        background: #38bdf8;
        color: #0f172a;
        font-weight: 600;
    }

    tr:nth-child(even) {
        background: #0f172a;
    }

    .btn {
        padding: 6px 12px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        margin-right: 5px;
        color: white;
        background: #38bdf8;
    }

    .btn-danger {
        background: red;
    }

    .no-data {
        text-align: center;
        padding: 20px;
        font-size: 16px;
        color: #94a3b8;
    }
</style>
</head>
<body>

<div class="sidebar">
    <h2>⚡ EV Owner Panel</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="add_station.php">➕ Add Charging Station</a>
    <a href="profile.php">👤 Profile</a>
    <a href="logout.php" style="background:#ef4444;">Logout</a>
</div>

<div class="content">
    <h1>Welcome, <?php echo $owner_name ?> 👋</h1>
    <p>Manage your EV charging stations below.</p>

    <table>
        <tr>
            <th>Station Name</th>
            <th>Location</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Actions</th>
        </tr>

        <?php
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>
                        <td>".$row['name']."</td>
                        <td>".$row['address']."</td>
                        <td>".$row['latitude']."</td>
                        <td>".$row['longitude']."</td>
                        <td>
                            <a class='btn' href='edit_station.php?id=".$row['id']."'>Edit</a>
                            <a class='btn btn-danger' href='delete_station.php?id=".$row['id']."'>Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo '<tr><td colspan="5" class="no-data">No stations added yet.</td></tr>';
        }
        ?>
    </table>
</div>

</body>
</html>
