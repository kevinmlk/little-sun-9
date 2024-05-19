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

    <!-- <ul class="nav nav-tabs mt-5">
      <li class="nav-item">
        <a id="tab-link-calendar" class="nav-link active" href="#">Calendar</a>
      </li>
      <li class="nav-item">
        <a id="tab-link-task-types" class="nav-link" href="#">Task types</a>
      </li>
    </ul> -->

    <!-- Calendar Section -->
    <section id="calendar-section" class="mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Shift's week overview</h2>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add shift</button>
      </div>

      

      <div id="calendar"></div>
    </section>
</body>
</html>
