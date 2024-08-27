<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  if (!empty($_POST)) {
    $user = new User();

    $user->setId($_POST['manager-select']);
    $user->setNewPassword($_POST['new-password']);

    // Run create user method
    $user->resetPassword();
  }

  // Redirect user to login page or show an error message
  header("Location: ../hubs.php");
  exit;