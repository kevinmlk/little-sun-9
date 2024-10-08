<?php
  include_once(__DIR__ . '/bootstrap.php');

  // Check if the user is logged in
  session_start();
  if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
  }

  // Shifts
  $shifts = Shift::getAllShifts();

  $currentShifts = [];
  $today = date('Y-m-d');

  // Iterate through each task
  foreach ($shifts as $s) {
    // Extract the date from StartTime
    $shiftDate = date("Y-m-d", strtotime($s["StartTime"]));
    // If the task's date is today, add it to $tasksToday array
    if ($shiftDate == $today && $s['EmployeeId'] === $_SESSION['id']) {
        $currentShifts[] = $s;
    }
  }

  $employeeAllShifts = [];

  foreach ($shifts as $s) {
    // Extract the date from StartTime
    $shiftDate = date("Y-m-d", strtotime($s["StartTime"]));

    if ($s['EmployeeId'] === $_SESSION['id'] && $shiftDate >= $today) {
        $employeeAllShifts[] = $s;
    }
  }

  // Get the total number of absents
  $absents = Absent::getAllAbsents();

  $currentAbsents = [];

  foreach ($absents as $a) {
    if ($a['EmployeeId'] === $_SESSION['id']) {
        $currentAbsents[] = $a;
    }
  }

  $allTasks = Task::getAllTaskTypes();

  $currentUserTask = '';

  foreach ($allTasks as $t) {
    if ($t['Id'] === $_SESSION['taskId']) {
        $currentUserTask = $t;
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
  <!-- Title -->
  <title>Little Sun</title>
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
              <a class="nav-link" href="hub-details.php?id=<?php echo $_SESSION['hubId']; ?>">Hub Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="calendar-manager.php">Calendar Overview</a>
            </li>
            <hr>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'Employee'): ?>
            <li class="nav-item">
              <a class="nav-link" href="calendar-employee.php">Calendar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Time Tracker</a>
            </li>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Manager'): ?>
            <li class="nav-item">
              <a class="nav-link" href="time-records.php">Time Records</a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
              <a class="nav-link" href="time-off-requests.php">Time Off Requests</a>
            </li>
          </ul>
          <a class="btn btn-outline-success mt-5" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="container">
    <ul class="nav nav-tabs mt-5">
      <li class="nav-item">
        <a id="tab-link-shifts" class="nav-link active" href="#">Shifts</a>
      </li>
      <li class="nav-item">
        <a id="tab-link-absents" class="nav-link" href="#">Absent</a>
      </li>
    </ul>

    <!-- Calendar Section -->
    <section id="shifts-section" class="mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Shifts overview</h2>
        <?php if (!empty($currentShifts)): ?>
        <!-- Button trigger modal -->
        <?php if (empty($currentShifts[0]['CheckIn'])): ?>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkInModal">Check in</button>
        <?php elseif (empty($currentShifts[0]['CheckOut'])): ?>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#checkOutModal">Check out</button>
        <?php else: ?>
          <p>U can rest, there are no more shifts for today!</p>
        <?php endif; ?>
        <?php endif; ?>
      </div>

      <!-- Modal Check In -->
      <div class="modal fade" id="checkInModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="checkInModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Check in shift</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="./includes/set-checkin.inc.php" method="post">
                <!-- Name -->
                <i class="mb-3">
                  <label for="employee-name" class="col-form-label">Name:</label>
                  <input name="employee-name" type="text" class="form-control" value="<?php echo $_SESSION['name']; ?>" disabled>
                  <input name="shift-id" type="text" class="form-control d-none" value="<?php echo $currentShifts[0]['Id']; ?>">
                </i>
                <!-- Task -->
                <div class="mb-3">
                  <label for="task" class="col-form-label">Task:</label>
                  <input name="task" type="text" class="form-control" value="<?php echo $currentShifts[0]['Taskname']; ?>" disabled>
                </div>
                <!-- Start Shift -->
                <div class="mb-3">
                  <label for="start-time" class="col-form-label">Start shift:</label>
                  <input name="start-time" class="form-control" type="text" value="<?php echo $currentShifts[0]['StartTime']; ?>" disabled>
                </div>
                <!-- Start Shift -->
                <div class="mb-3">
                  <label for="end-time" class="col-form-label">End shift:</label>
                  <input name="end-time" class="form-control" type="text" value="<?php echo $currentShifts[0]['EndTime']; ?>" disabled>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Check in now</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Check Out -->
      <div class="modal fade" id="checkOutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="checkOutModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Check out shift</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="./includes/set-checkout.inc.php" method="post">
                <!-- Name -->
                <i class="mb-3">
                  <label for="employee-name" class="col-form-label">Name:</label>
                  <input name="employee-name" type="text" class="form-control" value="<?php echo $_SESSION['name']; ?>" disabled>
                  <input name="shift-id" type="text" class="form-control d-none" value="<?php echo $currentShifts[0]['Id']; ?>">
                </i>
                <!-- Task -->
                <div class="mb-3">
                  <label for="task" class="col-form-label">Task:</label>
                  <input name="task" type="text" class="form-control" value="<?php echo $currentShifts[0]['Taskname']; ?>" disabled>
                </div>
                <!-- Start Shift -->
                <div class="mb-3">
                  <label for="start-time" class="col-form-label">Start shift:</label>
                  <input name="start-time" class="form-control" type="text" value="<?php echo $currentShifts[0]['StartTime']; ?>" disabled>
                </div>
                <!-- Start Shift -->
                <div class="mb-3">
                  <label for="end-time" class="col-form-label">End shift:</label>
                  <input name="end-time" class="form-control" type="text" value="<?php echo $currentShifts[0]['EndTime']; ?>" disabled>
                </div>
                <!-- Start Shift -->
                <div class="mb-3">
                  <label for="check-in-time" class="col-form-label">Checked in:</label>
                  <input name="check-in-time" class="form-control" type="text" value="<?php echo $currentShifts[0]['CheckIn']; ?>" disabled>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Check out now</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Calendar -->
      <div id="calendar"></div>
    </section>

    <!-- Absents section -->
    <section id="absents-section" class="mt-5 d-none">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Absents</h2>
        <?php if ($_SESSION['role'] === 'Employee'): ?>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAbsentModal">Add absent</button>
        <?php endif; ?>
      </div>

      <?php if ($_SESSION['role'] === 'Employee'): ?>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col"><strong>Id</strong></th>
            <th scope="col"><strong>Reason</strong></th>
            <th scope="col"><strong>Shift</strong></th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($absents)): ?>
          <?php foreach($currentAbsents as $c): ?>
            <tr>
              <th scope="row"><?php echo $c['Id']; ?></th>
              <td><?php echo $c['Type']; ?></td>
              <td><?php echo $c['StartTime']; ?> - <?php echo $c['EndTime']; ?></td>
            </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
      <?php endif; ?>

      <?php if ($_SESSION['role'] === 'Admin'): ?>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col"><strong>Name</strong></th>
            <th scope="col"><strong>Reason</strong></th>
            <th scope="col"><strong>Shift</strong></th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($absents)): ?>
          <?php foreach($absents as $a): ?>
            <tr>
              <th scope="row"><?php echo $a['Firstname']; ?> <?php echo $a['Lastname']; ?></th>
              <td><?php echo $a['Type']; ?></td>
              <td><?php echo $a['StartTime']; ?> - <?php echo $a['EndTime']; ?></td>
            </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
      <?php endif; ?>

      <!-- Modal Add Absent -->
      <div class="modal fade" id="addAbsentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addAbsentModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Add absent</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="./includes/add-absent.inc.php" method="post">
                <!-- Name -->
                <i class="mb-3">
                  <label for="employee-name" class="col-form-label">Name:</label>
                  <input name="employee-name" type="text" class="form-control" value="<?php echo $_SESSION['name']; ?>" disabled>
                </i>
                <!-- Task -->
                <div class="mb-3">
                  <label for="task" class="col-form-label">Task:</label>
                  <input name="task" type="text" class="form-control" value="<?php echo $currentUserTask['Taskname']; ?>" disabled>
                </div>
                <!-- Start Shift -->
                <div class="mb-3">
                  <label for="start-time" class="col-form-label">Choose shift:</label>
                  <select name="shift-select" class="form-select form-select-lg" id="shift-select">
                    <?php foreach ($employeeAllShifts as $es): ?>
                    <option value="<?php echo $es['Id']; ?>"><?php echo $es['StartTime']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <!-- Sick Leave Reason -->
                <div class="mb-3">
                  <label for="sick-leave-reason" class="col-form-label">Sick leave reason:</label>
                  <select name="sick-select" class="form-select form-select-lg" aria-label="Sick select" required>
                      <option value="sick">sick</option>
                      <option value="accident">accident</option>
                  </select>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Add absent for shift</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </section>
  </main>
  <!-- Links JS -->
  <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="./assets/fullcalendar/dist/index.global.min.js"></script>
  <script>
    'use strict';

    // Global variables
    const shiftsSection = document.querySelector('#shifts-section');
    const absentsSection = document.querySelector('#absents-section');
    const shiftsTabLink = document.querySelector('#tab-link-shifts');
    const absentsTabLink = document.querySelector('#tab-link-absents');

    // Setup function - loads when the DOM content is loaded
    const setup = () => {
      // Calendar
      const calendarEl = document.querySelector('#calendar');

      let calendar = new FullCalendar.Calendar(calendarEl, {
        themeSystem: 'bootstrap5',
        initialView: 'listDay',
        headerToolbar: {
          left: 'title',
          right: 'today',
        },
        events: 'includes/get-user-shifts-details.inc.php',
      });

      calendar.render();

      // Event listeners
      shiftsTabLink.addEventListener('click', showShifts);
      absentsTabLink.addEventListener('click', showAbsents);
    }

    const showShifts = () => {
      if (shiftsSection.classList.contains('d-none')) {
        absentsSection.classList.add('d-none');
        shiftsSection.classList.remove('d-none');
        shiftsTabLink.classList.add('active');
        absentsTabLink.classList.remove('active');
      }
    }

    const showAbsents = () => {
      if (absentsSection.classList.contains('d-none')) {
        shiftsSection.classList.add('d-none');
        absentsSection.classList.remove('d-none');
        absentsTabLink.classList.add('active');
        shiftsTabLink.classList.remove('active');
      }
    }

    // Load setup when the DOM content is loaded
    document.addEventListener('DOMContentLoaded', setup);
  </script>
</body>
</html>