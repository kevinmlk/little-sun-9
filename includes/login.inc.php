<?php

  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  // Check if theres a login attempt
  if (!empty($_POST)) {
    $user = new User();
    $user->setEmail($_POST['email']);
    $user->setPassword($_POST['password']);

    if ($user->loginUser()) {
      session_start();
      $_SESSION['loggedin'] = true;
			header('Location: ../index.php');
    } else {
      $error = true;
      header('Location: ../index.php');
    }
  }