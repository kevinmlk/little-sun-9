<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  session_start();

  if (!empty($_POST)) {
    $timeOffRequest = new TimeOffRequest();
    $timeOffRequest->setEmployee($_SESSION['id']);
    $timeOffRequest->setType($_POST['type-select']);
    $timeOffRequest->setStartDate($_POST['start-date']);
    $timeOffRequest->setEndDate($_POST['end-date']);
    $timeOffRequest->setReason('pending');
    $timeOffRequest->setStatus('pending');

    $timeOffRequest->addTimeOffRequest();
  }

  // Redirect user to login page or show an error message
  header('Location: ../time-off-requests.php');
  exit;