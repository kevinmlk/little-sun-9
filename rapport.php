



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
<h1>Ziekte Uren Overzicht</h1>
<p id="currentMonth"></p>
    <table>
        <thead>
            <tr>
                <th>Medewerker ID</th>
                <th>Totaal Zieke Uren</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data rijen zullen hier ingevuld worden -->
            <tr>
                <td>12345</td>
                <td>8 uur</td>
            </tr>
            <tr>
                <td>12346</td>
                <td>4 uur</td>
            </tr>
            <!-- Voorbeeld van statische data om het ontwerp te tonen -->
        </tbody>
    </table>

    <script>
        const monthNames = ["January", "February", "March", "April", "Mei", "June",
                            "July", "August", "September", "Oktober", "November", "December"];
        const now = new Date();
        const currentMonthName = monthNames[now.getMonth()]; 
        document.getElementById('currentMonth').innerText = 'Huidige maand: ' + currentMonthName;
    </script>
</body>
</html>