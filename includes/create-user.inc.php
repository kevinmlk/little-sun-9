<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  if (!empty($_POST)) {
    $user = new User();
    $user->setFirstname($_POST['firstname']);
    $user->setLastname($_POST['lastname']);
    $user->setEmail($_POST['email']);
    $user->setPassword($_POST['password']);
    $user->setRole($_POST['roles']);

    // Run create user method
    $user->createUser();
    echo 'User added!';
  }

  // Redirect user to login page or show an error message
  header("Location: ../create-user.php");
  exit;