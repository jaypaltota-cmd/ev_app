<?php
session_start();
include("../config/db.php");

$message = "";

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // plain text password

    // Check if email already exists
    $check = $conn->query("SELECT * FROM owners WHERE email='$email'");
    if($check->num_rows > 0){
        $message = "Email already registered!";
    } else {
        $sql = "INSERT INTO owners (name, email, password, verified) VALUES ('$name', '$email', '$password', 0)";
        if($conn->query($sql)){
            $message = "Registration successful! Wait for admin approval.";
        } else {
            $message = "Error: ".$conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Owner Registration</title></head>
<body>

<h2>Owner Registration</h2>
<p style="color:green;"><?php echo $message; ?></p>

<form method="post">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="register">Register</button>
</form>

</body>
</html>
