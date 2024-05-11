<?php
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

// Get the check-in datetime from the form
$checkInTime = $_POST['checkIn'];

// SQL to insert check-in time
$sql = "INSERT INTO your_table_name (check_in) VALUES ('$checkInTime')";

if ($conn->query($sql) === TRUE) {
  echo "Check-in recorded successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
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
        <label for="checkIn">Check-in:</label>
        <input type="datetime-local" name="checkIn" id="checkIn">
        <button type="submit">Check-in</button>
    </form>
</body>
</html>