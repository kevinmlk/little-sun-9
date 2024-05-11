<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  if (!empty($_POST)) {
    $shift = new Shift();
    $shift->setLocation($_POST['hub-select']);
    $shift->setEmployee($_POST['employee-select']);
    $shift->setTask($_POST['task-select']);
    $shift->setStartTime($_POST['start-time']);
    $shift->setEndTime($_POST['end-time']);

    // Add shift to db
    $shift->addShift();
  }

  // Redirect user to login page or show an error message
  header('Location: ../tasks.php');
  exit;