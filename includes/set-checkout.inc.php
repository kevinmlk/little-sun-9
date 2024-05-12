<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  // Start session to obtain user id
  session_start();

  // Checks if a form has been sent
  if (!empty($_POST)) {
    $shift = new Shift();

    $currentTime = date('Y-m-d\TH:i:s');
    $shift->setCheckOut($currentTime);
    $shiftId = $_POST['shift-id'];

    // Run create user method
    $shift->checkOut($shiftId);
  }

  // Redirect user to login page or show an error message
  header("Location: ../time-tracker.php");
  exit;