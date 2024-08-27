<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  // Checks if a form has been sent
  if (!empty($_POST)) {
    $location = new Location();
    $location->setHubName($_POST['hub-name']);
    $location->setHubLocation($_POST['hub-location']);

    // Run create user method
    $location->addHubLocation();
  }

  // Redirect user to login page or show an error message
  header("Location: ../hubs.php");
  exit;