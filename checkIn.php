<?php
//test if my button works
if(isset($_POST['checkIn'])){
    echo "Check-in successful";
}
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "little_sun1";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

?>




    




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
    <h1>Check-in</h1>
    <p>Check-in to your shift</p>
    <form action="checkIn.php" method="POST">
        <label for="checkIn">Check-in</label>
        <input type="submit" name="checkIn" value="Check-in">

    </form>
</body>
</html>