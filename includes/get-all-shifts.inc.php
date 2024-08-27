<?php
  include_once(__DIR__ . '/../bootstrap.php');

  
  // Shifts
  $shifts = Shift::getAllShifts();
  $data = [];

  foreach ($shifts as $s) {
    $startTime = (new DateTime($s['StartTime']))->format('Y-m-d\TH:i:s');
    $endTime = (new DateTime($s['EndTime']))->format('Y-m-d\TH:i:s');

    $data[] = [
      'title' => $s['Firstname'] . ' ' . $s['Lastname'],
      'start' => $startTime,
      'end' => $endTime,
    ];
  }

  echo json_encode($data);