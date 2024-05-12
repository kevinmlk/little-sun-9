<?php
  // Include bootstrap
  include_once(__DIR__ . '/bootstrap.php');

  

    // Function checks if the employee has a day off on the selected day
    $shifts = Shift::getUserShifts(20);
    $date = '2024-05-16';

    // Iterate through each shift
    foreach ($shifts as $s) {
        // Extract the date from StartTime
        $shiftDate = date("Y-m-d", strtotime($s["StartTime"]));
        // If the task's date is today, add it to $tasksToday array
        if ($shiftDate === date('Y-m-d', strtotime($date))) {
            $error = true;
        }
    }

    print_r($shifts);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if (isset($error)): ?>
        <p>ERRRROORRRR</p>
    <?php endif; ?>
</body>
</html>
