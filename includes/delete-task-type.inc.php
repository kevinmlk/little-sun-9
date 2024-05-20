<?php
  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  // Checks if a form has been sent
  if (!empty($_POST)) {
    $task = new Task();
    $task->setId($_POST['task-type-select']);

    $user = new User();
    $user->setTask($_POST['task-type-select']);
    $user->setNewTask(1);
    $user->editTaskType();

    // Run create user method
    $task->deleteTaskType();
  }

  // Redirect user to hubs overview page
  header("Location: ../tasks.php");
  exit;