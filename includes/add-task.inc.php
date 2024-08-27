<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  // Checks if a form has been sent
  if (!empty($_POST)) {
    $task = new Task();
    $task->setTaskName($_POST['task-type-name']);

    // Run create user method
    $task->createTaskType();
  }

  // Redirect user to login page or show an error message
  header("Location: ../tasks.php");
  exit;