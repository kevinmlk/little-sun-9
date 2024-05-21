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

  $clockedShifts = [];

  foreach ($shifts as $s) {
    // Check if both CheckIn and CheckOut are not empty
    if (!empty($s['CheckIn']) && !empty($s['CheckOut'])) {
      // Calculate the duration of the shift
      $checkInTime = new DateTime($s['CheckIn']);
      $checkOutTime = new DateTime($s['CheckOut']);
      $shiftDuration = $checkOutTime->getTimestamp() - $checkInTime->getTimestamp();

      // Calculate the expected duration based on StartTime and EndTime
      $startTime = new DateTime($s['StartTime']);
      $endTime = new DateTime($s['EndTime']);
      $expectedDuration = $endTime->getTimestamp() - $startTime->getTimestamp();

      // Calculate overtime duration in seconds
      $overtimeSeconds = $shiftDuration - $expectedDuration;

      // Check if there is overtime
      if ($overtimeSeconds > 0) {
          // Calculate hours, minutes, and seconds
          $hours = floor($overtimeSeconds / 3600);
          $minutes = floor(($overtimeSeconds % 3600) / 60);
          $seconds = $overtimeSeconds % 60;

          // Format overtime duration
          $overtimeFormatted = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

          // Add overtime duration to the shift data
          $s['Overtime'] = $overtimeFormatted;

          // Store the row in $clockedShifts array
          $clockedShifts[] = $s;
      }
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
              <a class="nav-link" href="time-tracker.php">Time Tracker</a>
            </li>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Manager'): ?>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Time Records</a>
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
        <a id="tab-link-overtime" class="nav-link active" href="#overtime-section">Overtime</a>
      </li>
      <li class="nav-item">
        <a id="tab-link-absents" class="nav-link" href="#absents-section">Absent</a>
      </li>
    </ul>

    <!-- Overtime Section -->
    <section id="overtime-section" class="mt-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Overtime</h2>
        <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#overtimeModal"><i class="bi bi-funnel me-2"></i>Extra options</button>
      </div>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col"><strong>Name</strong></th>
            <th scope="col"><strong>Shift</strong></th>
            <th scope="col"><strong>Clock</strong></th>
            <th scope="col"><strong>Overtime</strong></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($clockedShifts as $cs): ?>
            <tr>
              <th scope="row"><?php echo $cs['Firstname']; ?> <?php echo $cs['Lastname']; ?></th>
              <td><?php echo $cs['StartTime']; ?> - <?php echo $cs['EndTime']; ?></td>
              <td><?php echo $cs['CheckIn']; ?> - <?php echo $cs['CheckOut']; ?></td>
              <td><?php echo $cs['Overtime']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <!-- overtimeModalM -->
      <div class="modal fade" id="overtimeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="overtimeModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Add shift</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="" method="post">
                <!-- Hub Select -->
                <div class="mb-3">
                  <label for="hub-select" class="col-form-label">Choose employee:</label>
                  <select name="hub-select" class="form-select" aria-label="Hub select" id="hub-select" required>
                    <?php foreach($clockedShifts as $cs): ?>
                      <option value="<?php echo $cs['Id']; ?>"><?php echo $cs['Firstname']; ?> <?php echo $cs['Lastname']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="mb-3">
                      <label for="month-overtime" class="col-form-label">Overtime </label>
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

    </section>

    <!-- Absents section -->
    <section id="absents-section" class="mt-5 d-none">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Absents</h2>
        <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#filterAbsentsModal"><i class="bi bi-funnel me-2"></i>Filter employees</button>
      </div>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col"><strong>Name</strong></th>
            <th scope="col"><strong>Reason</strong></th>
            <th scope="col"><strong>Shift</strong></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($absents as $a): ?>
            <tr>
              <th scope="row"><?php echo $a['Firstname']; ?> <?php echo $a['Lastname']; ?></th>
              <td><?php echo $a['Type']; ?></td>
              <td><?php echo $a['StartTime']; ?> - <?php echo $a['EndTime']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    </section>
  </main>
  <!-- Links JS -->
  <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
  <script>
    'use strict';

    // Global variables
    const overtimeSection = document.querySelector('#overtime-section');
    const absentsSection = document.querySelector('#absents-section');
    const overtimeTabLink = document.querySelector('#tab-link-overtime');
    const absentsTabLink = document.querySelector('#tab-link-absents');

    // Setup function - loads when the DOM content is loaded
    const setup = () => {
      // Event listeners
      overtimeTabLink.addEventListener('click', showReports);
      absentsTabLink.addEventListener('click', showAbsents);
    }

    const showReports = () => {
      if (overtimeSection.classList.contains('d-none')) {
        absentsSection.classList.add('d-none');
        overtimeSection.classList.remove('d-none');
        overtimeTabLink.classList.add('active');
        absentsTabLink.classList.remove('active');
      }
    }

    const showAbsents = () => {
      if (absentsSection.classList.contains('d-none')) {
        overtimeSection.classList.add('d-none');
        absentsSection.classList.remove('d-none');
        absentsTabLink.classList.add('active');
        overtimeTabLink.classList.remove('active');
      }
    }

    // Load setup when the DOM content is loaded
    document.addEventListener('DOMContentLoaded', setup);
  </script>
</body>
</html>