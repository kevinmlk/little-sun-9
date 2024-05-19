<?php
$servername = "localhost";
$username = "root";  // Verander naar je eigen gebruikersnaam
$password = "root";      // Voer hier je eigen wachtwoord in
$dbname = "little_sun1";  // Verander naar de naam van je database

// Maak de verbinding
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}


// Huidige maand en jaar
$year = date("Y");
$month = date("m");
$startDate = "$year-$month-01 10:00:00";
$endDate = date("Y-m-t", strtotime($startDate)) . " 11:00:00";

// SQL-query
$sql = "SELECT employee_id, start_time, end_time, status FROM absence";
$result = $conn->query($sql);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
<body>
<h1>Absence rapport</h1>
    <table>
        <tr>
            <th>Medewerker ID</th>
            <th>Starttijd</th>
            <th>Eindtijd</th>
            <th>Status</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["employee_id"] . "</td>
                        <td>" . $row["start_time"] . "</td>
                        <td>" . $row["end_time"] . "</td>
                        <td>" . $row["status"] . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Geen gegevens gevonden</td></tr>";
        }
        ?>
    </table>

    <form action="" method="post">
    <label for="month">Maand:</label>
    <select id="month" name="month">
        <option value="1">Januari</option>
        <option value="2">Februari</option>
        <option value="3">Maart</option>
        <option value="4">April</option>
        <option value="5">Mei</option>
        <option value="6">Juni</option>
        <option value="7">Juli</option>
        <option value="8">Augustus</option>
        <option value="9">September</option>
        <option value="10">Oktober</option>
        <option value="11">November</option>
        <option value="12">December</option>
    </select>

    <label for="year">Jaar:</label>
    <input type="number" id="year" name="year" min="2000" max="2099" value="<?php echo date("Y"); ?>">

    <input type="submit" value="Zoek">
</form>

</body>
</html>