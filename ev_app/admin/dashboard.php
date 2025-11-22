<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once "../config/db.php";

$result = $conn->query("SELECT * FROM owners");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>

<h2>Admin Dashboard</h2>
<a href="logout.php">Logout</a>

<h3>Owner Approvals</h3>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['verified']; ?></td>
        <td>
            <?php if ($row['verified'] == 0) { ?>
                <a href="approve.php?id=<?php echo $row['id']; ?>">Approve</a>
            <?php } else { ?>
                Approved
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
