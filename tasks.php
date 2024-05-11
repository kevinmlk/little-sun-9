<?php
  // Include bootstrap
  include_once(__DIR__ . '/bootstrap.php');

  session_start();

  if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Manager') {
    // Redirect user to login page or show an error message
    header("Location: index.php");
    exit;
  }

  // Toon alle gebruikers
  $tasks = Task::getAllTaskTypes();
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Links CSS -->
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="./assets/bootstrap/icons/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="./assets/css/style.css">
  <title>Tasks | Little Sun Shiftplanner</title>
</head>
<body>
  <!-- Start Navbar -->
  <nav class="navbar bg-body-tertiary fixed-top">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="profile.php"><?php echo $_SESSION['name']; ?> (<?php echo $_SESSION['role']; ?>)</a>
      <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Little Sun</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 mb-5">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Dashboard</a>
            </li>
            <hr>
            <?php if ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Manager'): ?>
            <li class="nav-item">
              <a class="nav-link" href="users.php">Users Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="hubs.php">Hub Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="tasks.php">Task Overview</a>
            </li>
            <hr>
            <?php endif; ?>
            <li class="nav-item">
              <a class="nav-link" href="calendar.php">Calendar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Time Tracker</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Shiftplan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Shiftswap</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Working hours</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Vacation days</a>
            </li>
          </ul>
          <a class="btn btn-outline-success mt-5" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="container pt-5">
    <ul class="nav nav-tabs mt-5">
      <li class="nav-item">
        <a id="tab-link-calendar" class="nav-link active" href="#">Calendar</a>
      </li>
      <li class="nav-item">
        <a id="tab-link-task-types" class="nav-link" href="#">Task types</a>
      </li>
    </ul>

    <!-- Calendar Section -->
    <section id="calendar-section" class="mt-5">
      <div id="calendar"></div>
    </section>

    <!-- Task Types Section -->
    <section id="task-type-section" class="mt-5 d-none">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Tasks overview</h2>
        <a href="create-task.php" class="btn btn-primary">Add new task type</a>
      </div>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col"><strong>Id</strong></th>
            <th scope="col"><strong>Task type name</strong></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($tasks as $key => $task): ?>
            <tr>
              <th scope="row"><?php echo $task['Id']; ?></th>
              <td><?php echo $task['Taskname']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </main>
  
  <!-- Links JS -->
  <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="./assets/fullcalendar/dist/index.global.min.js"></script>
  <script>
    'use strict';

    // Global variables
    const calendarSection = document.querySelector('#calendar-section');
    const taskTypeSection = document.querySelector('#task-type-section');
    const calendarTabLink = document.querySelector('#tab-link-calendar');
    const taskTypeTabLink = document.querySelector('#tab-link-task-types');

    // Setup function - loads when the DOM content is loaded
    const setup = () => {
      // Calendar
      const calendarEl = document.querySelector('#calendar');

      let calendar = new FullCalendar.Calendar(calendarEl, {
        themeSystem: 'bootstrap5',
        initialView: 'listWeek',
        headerToolbar: {
          left: 'title',
          right: 'today prev,next'
        },
        events: 'includes/get-all-shifts.inc.php',
      });

      calendar.render();

      // Event listeners
      calendarTabLink.addEventListener('click', showCalendar);
      taskTypeTabLink.addEventListener('click', showTaskTypes);
    }

    const showCalendar = () => {
      if (calendarSection.classList.contains('d-none')) {
        taskTypeSection.classList.add('d-none');
        calendarSection.classList.remove('d-none');
        calendarTabLink.classList.add('active');
        taskTypeTabLink.classList.remove('active');
      }
    }

    const showTaskTypes = () => {
      if (taskTypeSection.classList.contains('d-none')) {
        calendarSection.classList.add('d-none');
        taskTypeSection.classList.remove('d-none');
        taskTypeTabLink.classList.add('active');
        calendarTabLink.classList.remove('active');
      }
    }

    // Load setup when the DOM content is loaded
    document.addEventListener('DOMContentLoaded', setup);
  </script>
</body>
</html>