<?php

  // Include bootstrap
  include_once(__DIR__ . '/../bootstrap.php');

  // Checks if a form has been sent
  if (!empty($_POST)) {
    $user = new User();
    $user->setTask($_POST['task-select']);
    $user->setId($_POST['employee-select']);	
    
    $user->assignTask();
  }

  // Redirect user to hub details pagw
  header("Location: {$_SERVER['HTTP_REFERER']}");
  exit;