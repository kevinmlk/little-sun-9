<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  if (!empty($_POST)) {
    $user = new User();
    $user->setFirstname($_POST['firstname']);
    $user->setLastname($_POST['lastname']);
    $user->setEmail($_POST['email']);
    $user->setPassword($_POST['password']);

    $profileImageName = $_POST['firstname'] . '-' . $_POST['lastname'] . '-' . $_FILES["profile-picture-input"]["name"];

    // For image upload
    $imageFolder = "../images/profile/";
    $imageFile = $imageFolder . basename($profileImageName);

    if(move_uploaded_file($_FILES["profile-picture-input"]["tmp_name"], $imageFile)) {
      $user->setProfilePicture($profileImageName);
    } else {
      $error = 'There was an error uploading the file.';
      // Redirect user to login page or show an error message
      header("Location: ../hub-details.php?id=" . $_POST['hub-input']);
      exit;
    }

    $user->setRole(1);
    $user->setTask(1);
    $user->setLocation($_POST['hub-input']);

    // Run create user method
    $user->createUser();
  }

  // Redirect user to login page or show an error message
  header("Location: ../hub-details.php?id=" . $_POST['hub-input']);
  exit;