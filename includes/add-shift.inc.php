<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  if (!empty($_POST)) {
    $shift = new Shift();
    $shift->setEmployee($_POST['employee-select']);
    $shift->setStartTime($_POST['start-time']);
    $shift->setEndTime($_POST['end-time']);

    // Add shift to db
    $shift->addShift();
  }

  // Redirect user to login page or show an error message
  session_start();

  if ($_SESSION['role'] === 'Admin') {
    header('Location: ../calendar.php');
    exit;
  } else {
    header('Location: ../calendar-manager.php');
    exit;
  }