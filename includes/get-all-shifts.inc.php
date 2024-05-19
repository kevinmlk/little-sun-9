<?php
  include_once(__DIR__ . '/../bootstrap.php');

  
  // Shifts
  $shifts = Shift::getAllShifts();
  $data = [];

  foreach ($shifts as $s) {
    $startTime = (new DateTime($s['StartTime']))->format('Y-m-d\TH:i:s');
    $endTime = (new DateTime($s['EndTime']))->format('Y-m-d\TH:i:s');

    $data[] = [
      'title' => $s['Taskname'] . ' by ' . $s['Firstname'] . ' ' . $s['Lastname'] . ' in ' . $s['Hubname'] . ' (' . $s['Hublocation'] . ')',
      'start' => $startTime,
      'end' => $endTime,
    ];
  }

  // print_r($shifts);

  echo json_encode($data);
  