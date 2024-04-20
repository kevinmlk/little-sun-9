<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  // Checks if a form has been sent
  if (!empty($_POST)) {
    $location = new Location();
    $location->setHubName($_POST['hub-overview']);

    // Run create user method
    $location->removeHubLocation();
  }

  // Redirect user to login page or show an error message
  header("Location: ../create-hub.php");
  exit;