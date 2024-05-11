<?php
//button to check-in[x]
//check if the button is clicked[x]
//if the button is clicked, echo "Check-in successful"[x]
//connect to the database[x]
//create a connection[x]
//check if the connection is successful[x]
//if the connection is successful, echo "Connected successfully[x]"
//if click on the button, insert a new row in the database with the current date and time[]


if(isset($_POST['checkOut'])){
    echo "Check-in successful";
}
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "little_sun1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$currentDateTime = date('Y-m-d H:i:s');
$sql = "INSERT INTO workingHours (check_out_time) VALUES ('$currentDateTime')";

 if ($conn->query($sql) === TRUE) {
        echo "Check-out successful";
    } else {
        echo "Error: " . $conn->error;
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
    <h1>Check-out</h1>
    <p>Check-our to your shift</p>
    <form action="checkOut.php" method="POST">
        <label for="checkOut">Check-out</label>
        <input type="submit" name="checkOut" value="Check-out">

    </form>
</body>
</html>