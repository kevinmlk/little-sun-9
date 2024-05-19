<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  // Checks if a form has been sent
  if (!empty($_POST)) {
    $task = new Task();
    $task->setId($_POST['task-type-select']);

    // Run create user method
    $task->deleteTaskType();
  }

  // Redirect user to hubs overview page
  header("Location: ../tasks.php");
  exit;