<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  // Start session to obtain user id
  session_start();

  // Checks if a form has been sent
  if (!empty($_POST)) {
    $timeOffRequest = new TimeOffRequest();

    $timeOffRequest->setId($_POST['period-select']);
    $timeOffRequest->setStatus($_POST['status-select']);
    $timeOffRequest->setReason($_POST['decision-input']);

    $timeOffRequest->setTimeOffRequestStatus();
  }

  // Redirect user to login page or show an error message
  header("Location: ../time-off-requests.php");
  exit;