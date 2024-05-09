<?php

  $data = [
    [
      'title' => 'event1',
      'start' => '2024-05-01',
    ],
    [
      'title' => 'event2',
      'start' => '2024-05-05',
      'end' => '2024-05-07',
    ],
    [
      'title' => 'event3',
      'start' => '2024-05-09T12:30:00',
      'allDay' => false,
    ],
  ];
  echo json_encode($data);