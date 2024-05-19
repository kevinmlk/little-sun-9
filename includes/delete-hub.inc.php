<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  // Checks if a form has been sent
  if (!empty($_POST)) {
    $location = new Location();
    $location->setId($_POST['hub-input']);

    // Run create user method
    $users = new User();
    $users->setLocation($_POST['hub-input']);
    $users->deleteAllHubUsers();
    $location->deleteHub();
  }

  // Redirect user to hubs overview page
  header("Location: ../hubs.php");
  exit;