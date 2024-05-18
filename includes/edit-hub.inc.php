<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  // Checks if a form has been sent
  if (!empty($_POST)) {
    $location = new Location();
    // Old hub name
    $location->setId($_POST['hub-input']);
    // New hub name & location
    $location->setNewHubName($_POST['new-hub-name']);
    $location->setNewHubLocation($_POST['new-hub-location']);

    // Run create user method
    $location->editHubLocation();
  }

  // Redirect user to hub details page
  header("Location: ../hub-details.php?id=" . $_POST['hub-input']);
  exit;