<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  if (!empty($_POST)) {
    $absent = new Absent();
    $absent->setType($_POST['sick-select']);
    $absent->setShift($_POST['shift-select']);

    // Add shift to db
    $absent->addAbsent();
  }

  // Redirect user to login page or show an error message
  header('Location: ../time-tracker.php');
  exit;