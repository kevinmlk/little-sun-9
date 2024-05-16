<?php
  // Include bootstrap
  include_once(__DIR__ . '/bootstrap.php');

  session_start();

  if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Manager') {
    // Redirect user to login page or show an error message
    header("Location: index.php");
    exit;
  }

  // Get all tasks from db
  $tasks = Task::getAllTaskTypes();

  // Get all hub locations from db
  $locations = Location::getAllHubs();

  // Array to store rows with ManagerId 3
  $managerHubs = [];

  // Loop through the array and store rows where ManagerId is 3
  foreach ($locations as $l) {
    if ($l['ManagerId'] === $_SESSION['id']) {
        $managerHubs[] = $l;
    }
  }

  // Get all employees from db
  $users = User::getAllUsers();

  $employees = [];

  foreach ($users as $u) {
    if ($u['RoleName'] === 'Employee') {
      $employees[] = $u;
    }
  }

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
              <a class="nav-link" href="hubs.php">Hubs Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Task Overview</a>
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
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Shift's week overview</h2>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add shift</button>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Add shift</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <!-- Login error message -->
              <?php	if (!empty($error)): ?>
              <div class="form-error">
                <p>
                  Sorry, the selected employee has a day off on that day. Select another day to plan the shift.
                </p>
              </div>
              <?php endif; ?>
              <form action="./includes/add-shift.inc.php" method="post">
                <!-- Hub Select -->
                <div class="mb-3">
                  <!-- Manager hub view -->
                  <?php if ($_SESSION['role'] === 'Manager'): ?>
                  <label for="hub-select" class="col-form-label">Choose hub:</label>
                  <select name="hub-select" class="form-select" aria-label="Hub select" required>
                    <?php foreach($managerHubs as $h): ?>
                      <option value="<?php echo $h['Id']; ?>"><?php echo $h['Hubname'];?> (<?php echo $h['Hublocation']; ?>)</option>
                    <?php endforeach; ?>
                  </select>
                  <?php endif; ?>

                  <!-- Admin hub view -->
                  <?php if ($_SESSION['role'] === 'Admin'): ?>
                  <label for="hub-select" class="col-form-label">Choose hub:</label>
                  <select name="hub-select" class="form-select" aria-label="Hub select" required>
                    <?php foreach($locations as $l): ?>
                      <option value="<?php echo $l['Id']; ?>"><?php echo $l['Hubname'];?> (<?php echo $l['Hublocation']; ?>)</option>
                    <?php endforeach; ?>
                  </select> 
                  <?php endif; ?>
                </div>
                <!-- Employee Select -->
                <div class="mb-3">
                  <label for="employee-select" class="col-form-label">Choose an employee from hub:</label>
                  <select name="employee-select" class="form-select" aria-label="Employee select" required>
                    <?php foreach($employees as $e): ?>
                      <option value="<?php echo $e['Id']; ?>"><?php echo $e['Firstname'];?> <?php echo $e['Lastname']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <!-- Task -->
                <div class="mb-3">
                  <label for="task-select" class="col-form-label">Assign task:</label>
                  <select name="task-select" class="form-select" aria-label="Task select" required>
                    <?php foreach($tasks as $t): ?>
                      <option value="<?php echo $t['Id']; ?>"><?php echo $t['Taskname'];?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <!-- Start Shift -->
                <div class="mb-3">
                  <label for="start-time" class="col-form-label">Start shift:</label>
                  <input name="start-time" id="start-time" class="form-control" min="<?php echo date("Y-m-d\TH:i"); ?>" type="datetime-local" required>
                </div>
                <!-- End Shift -->
                <div class="mb-3">
                  <label for="end-time" class="col-form-label">End shift:</label>
                  <input name="end-time" class="form-control" min="<?php echo date("Y-m-d\TH:i"); ?>" type="datetime-local" required>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Add new shift</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div id="calendar"></div>
    </section>

    <!-- Task Types Section -->
    <section id="task-type-section" class="mt-5 d-none">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Tasks types overview</h2>
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
          right: 'today prev,next',
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

    // Disable specific dates
    var disabledDates = ['2024-05-21']; // Add your disabled dates here
    var inputDate = document.getElementById('start-time');
    
    inputDate.addEventListener('input', function() {
        var selectedDate = new Date(inputDate.value);
        var formattedDate = selectedDate.toISOString().slice(0, 10); // Get the date in YYYY-MM-DD format
        
        if (disabledDates.includes(formattedDate)) {
            inputDate.setCustomValidity('Employee has time off on this date, please select another date.');
        } else {
            inputDate.setCustomValidity('');
        }
    });

    // Load setup when the DOM content is loaded
    document.addEventListener('DOMContentLoaded', setup);
  </script>
</body>
</html>