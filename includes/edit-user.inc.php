<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  if (!empty($_POST)) {
    $user = new User();
    $user->setFirstname($_POST['user-select']);
    $user->setNewPassword($_POST['new-password']);

    // Run create user method
    $user->editUserPassword();
  }

  // Redirect user to login page or show an error message
  header("Location: ../create-user.php");
  exit;