<?php

  include_once(__DIR__ . '/classes/Shift.php');

  $allShifts = Shift::getAllShifts();

  $data = [];

  foreach ($allShifts as $shift) {
    $startTime = (new DateTime($shift['StartTime']))->format('Y-m-d\TH:i:s');
    $endTime = (new DateTime($shift['EndTime']))->format('Y-m-d\TH:i:s');

    $data[] = [
      'title' => $shift['Taskname'],
      'start' => $startTime,
      'end' => $endTime,
    ];
  }

  // $data = [
  //   [
  //     'title' => 'event1',
  //     'start' => '2024-05-01',
  //   ],
  //   [
  //     'title' => 'event2',
  //     'start' => '2024-05-05',
  //     'end' => '2024-05-07',
  //   ],
  //   [
  //     'title' => 'event3',
  //     'start' => '2024-05-09T12:30:00',
  //     'allDay' => false,
  //   ],
  // ];
  echo json_encode($data);