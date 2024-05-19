<?php
  include_once(__DIR__ . '/bootstrap.php');

  // Check if the user is logged in
  session_start();
  if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
  }

  // Show all locations
  $locations = Location::getAllHubs();

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
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="./assets/images/favicon_io/favicon.ico">
  <!-- Title -->
  <title>Calendar | Little Sun Shiftplanner</title>
</head>
<body>
  <!-- Start Navbar -->
  <nav class="navbar bg-dark border-bottom border-body sticky-top mb-5" data-bs-theme="dark">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <span class="navbar-brand"><?php echo $_SESSION['name']; ?> <span class="badge rounded-pill text-bg-warning ms-2"><?php echo $_SESSION['role']; ?></span></span>
      <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Little Sun</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <?php if (!empty($_SESSION['profile-picture'])): ?>
          <img src="./images/profile/<?php echo $_SESSION['profile-picture']; ?>" id="img-navbar" class="h-50" alt="<?php echo $_SESSION['name']; ?> profile picture">
          <?php endif; ?>
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 mb-5">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Dashboard</a>
            </li>
            <?php if ($_SESSION['role'] === 'Admin'): ?>
            <hr>
            <li class="nav-item">
              <a class="nav-link" href="hubs.php">Hubs Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="tasks.php">Tasks Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="calendar.php">Calendar Overview</a>
            </li>
            <hr>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'Manager'): ?>
            <hr>
            <li class="nav-item">
              <a class="nav-link" href="hub-details.php?id=<?php echo $currentHub['Id']; ?>">Hub Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="calendar-manager.php">Calendar Overview</a>
            </li>
            <hr>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'Employee'): ?>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Calendar</a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
              <a class="nav-link" href="time-tracker.php">Time Tracker</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Shiftswap</a>
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

  <!-- Start main content -->
  <main class="container mt-5">
    <ul class="nav nav-tabs mt-5">
      <li class="nav-item">
        <a id="tab-link-calendar" class="nav-link active" href="#calendar-section">Calendar</a>
      </li>
      <li class="nav-item">
        <a id="tab-link-shifts" class="nav-link" href="#shifts-section">Shifts</a>
      </li>
    </ul>

    <!-- Calendar Section -->
    <section id="calendar-section" class="mt-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Work schedule</h2>
      </div>
      <div id="calendar">
      </div>
    </section>

    <!-- Shifts section -->
    <section id="shifts-section" class="mt-5 d-none">
      <div id="calendar-list"></div>
    </section>
  </main>
  <!-- Links JS -->
  <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="./assets/fullcalendar/dist/index.global.min.js"></script>
  <script src="./assets/js/app.js"></script>
  <script>
    'use strict';

    // Global variables
    const calendarSection = document.querySelector('#calendar-section');
    const shiftsSection = document.querySelector('#shifts-section');
    const calendarTabLink = document.querySelector('#tab-link-calendar');
    const shiftsTabLink = document.querySelector('#tab-link-shifts');

    // Calendar
    const calendarEl = document.querySelector('#calendar');

    // Calendar list
    const calendarListEl = document.querySelector('#calendar-list');

    // Setup function - loads when the DOM content is loaded
    const setup = () => {

      let calendar = new FullCalendar.Calendar(calendarEl, {
        themeSystem: 'bootstrap5',
        initialView: 'dayGridMonth',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'timeGridDay,timeGridWeek,dayGridMonth'
        },
        events: 'includes/get-user-shifts.inc.php',
      });

      let calendarList = new FullCalendar.Calendar(calendarListEl, {
        themeSystem: 'bootstrap5',
        initialView: 'listWeek',
        headerToolbar: {
          left: 'prev,next',
          center: 'title',
          right: 'today'
        },
        events: 'includes/get-user-shifts-details.inc.php',
      });
      
      calendarList.render();

      calendar.render();

      // Event listeners
      calendarTabLink.addEventListener('click', showCalendar);
      shiftsTabLink.addEventListener('click', showShifts);
    }

    const showCalendar = () => {
      if (calendarSection.classList.contains('d-none')) {
        shiftsSection.classList.add('d-none');
        calendarSection.classList.remove('d-none');
        setTimeout(function() {
          // Your function code goes here
          calendarEl.classList.add('min-vh-100');
        }, 1000);
        calendarTabLink.classList.add('active');
        shiftsTabLink.classList.remove('active');
      }
    }

    const showShifts = () => {
      if (shiftsSection.classList.contains('d-none')) {
        calendarSection.classList.add('d-none');
        shiftsSection.classList.remove('d-none');
        setTimeout(function() {
          // Your function code goes here
          calendarListEl.classList.add('min-vh-100');
        }, 1000);
        shiftsTabLink.classList.add('active');
        calendarTabLink.classList.remove('active');
      }
    }

    // Load setup when the DOM content is loaded
    document.addEventListener('DOMContentLoaded', setup);

  </script>
</body>
</html>