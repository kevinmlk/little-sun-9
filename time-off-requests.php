<?php
  // Include bootstrap
  include_once(__DIR__ . '/bootstrap.php');

  session_start();

  if (!isset($_SESSION['loggedin'])) {
    // Redirect user to login page or show an error message
    header("Location: index.php");
    exit;
  }

  // Get all time off requests from db
  $timeOffRequests = TimeOffRequest::getAllTimeOffRequests();

  $currentTimeOffRequests = [];

  foreach ($timeOffRequests as $tor) {
    if ($tor['LocationId'] === $_SESSION['hubId']) {
        $currentTimeOffRequests[] = $tor;
    }
  }

  $userTimeOffRequests = [];

  foreach ($timeOffRequests as $tor) {
    if ($tor['LocationId'] === $_SESSION['hubId'] && $tor['EmployeeId'] === $_SESSION['id']) {
        $userTimeOffRequests[] = $tor;
    }
  }

  $users = User::getAllUsers();

  $currentHubEmployees = [];

  foreach ($users as $u) {
    if ($u['LocationId'] === $_SESSION['hubId'] && $u['RoleName'] === 'Employee') {
      $currentHubEmployees[] = $u;
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
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="./assets/images/favicon_io/favicon.ico">
  <title>Time Off Requests | Little Sun Shiftplanner</title>
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
              <a class="nav-link" href="time-records.php">Time Records</a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
              <a class="nav-link active" href="#">Time Off Requests</a>
            </li>
          </ul>
          <a class="btn btn-outline-success mt-5" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="container">
    <?php if ($_SESSION['role'] === 'Manager' || $_SESSION['role'] === 'Admin'): ?>
    <!-- Time Off Request Manager Section -->
    <section id="time-off-request-manager" class="mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All time off requests</h2>
        <?php if ($_SESSION['role'] === 'Manager'): ?>
        <div>
          <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#setTimeOffRequestModal"><i class="bi bi-pencil-square me-2"></i>Set time off request</button>
        </div>
        <?php endif; ?>
      </div>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col"><strong>Id</strong></th>
            <th scope="col"><strong>Employee</strong></th>
            <th scope="col"><strong>Time off type</strong></th>
            <th scope="col"><strong>Start date</strong></th>
            <th scope="col"><strong>End date</strong></th>
            <th scope="col"><strong>Status</strong></th>
            <th scope="col"><strong>Reason</strong></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($currentTimeOffRequests as $ctor): ?>
            <tr>
              <th scope="row"><?php echo $ctor['TimeOffRequestId']; ?></th>
              <td><?php echo $ctor['Firstname'] . ' ' . $ctor['Lastname']; ?></td>
              <td><?php echo $ctor['Type']; ?></td>
              <td><?php echo $ctor['StartDate']; ?></td>
              <td><?php echo $ctor['EndDate']; ?></td>
              <td><?php echo $ctor['Status']; ?></td>
              <td><?php echo $ctor['Reason']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <!-- setTimeOffRequestModal -->
      <div class="modal fade" id="setTimeOffRequestModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="setTimeOffRequestModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Time off request</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="./includes/set-time-off-request.inc.php" method="post">
                <!-- Employee Select -->
                <div class="mb-3">
                  <label for="employee-select" class="col-form-label">Time Request employee:</label>
                  <select name="employee-select" class="form-select" id="employee-select" aria-label="Employee select" required>
                    <?php foreach ($currentHubEmployees as $che): ?>
                    <option value="<?php echo $che['Id']; ?>"><?php echo $che['Firstname'] . ' ' . $che['Lastname']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <!-- Time Off Period -->
                <div class="mb-3">
                  <label for="period-select" class="col-form-label">Time off period:</label>
                  <select name="period-select" class="form-select" id="period-select" aria-label="Period select" required>
                  </select>
                </div>
                <!-- Time Off Type -->
                <div class="mb-3">
                  <label for="type-select" class="col-form-label">Reason time off:</label>
                  <select name="type-select" class="form-select" id="type-select" aria-label="Type select" required>
                  </select>
                </div>
                <!-- Time Off Status -->
                <div class="mb-3">
                  <label for="status-select" class="col-form-label">Status time off:</label>
                  <select name="status-select" class="form-select" id="status-select" aria-label="Status select" required>
                    <option value="pending">pending</option>
                    <option value="approved">approved</option>
                    <option value="denied">denied</option>
                  </select>
                </div>
                <!-- Reason Decision -->
                <div class="mb-3">
                  <label for="decision-input" class="col-form-label">Reason decision:</label>
                  <input type="text" name="decision-input" class="form-control" id="decision-input">
                </div>
                <!-- Submit Button -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Update time off request</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </section>
    <?php endif; ?>
    
    <?php if ($_SESSION['role'] === 'Employee'): ?>
    <section id="time-request-employee">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>My time off requests</h2>
        <div>
          <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#createTimeOffRequestModal"><i class="bi bi-file-plus me-2"></i>Create time off request</button>
        </div>
      </div>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col"><strong>Id</strong></th>
            <th scope="col"><strong>Time off type</strong></th>
            <th scope="col"><strong>Start date</strong></th>
            <th scope="col"><strong>End date</strong></th>
            <th scope="col"><strong>Status</strong></th>
            <th scope="col"><strong>Reason</strong></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($userTimeOffRequests as $utor): ?>
            <tr>
              <th scope="row"><?php echo $utor['TimeOffRequestId']; ?></th>
              <td><?php echo $utor['Type']; ?></td>
              <td><?php echo $utor['StartDate']; ?></td>
              <td><?php echo $utor['EndDate']; ?></td>
              <td><?php echo $utor['Status']; ?></td>
              <td><?php echo $utor['Reason']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <!-- createTimeOffRequestModal -->
      <div class="modal fade" id="createTimeOffRequestModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createTimeOffRequestModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Time off request</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="./includes/add-time-off-request.inc.php" method="post">
                <!-- Time Off Type -->
                <div class="mb-3">
                  <label for="type-select" class="col-form-label">Status time off:</label>
                  <select name="type-select" class="form-select" id="type-select" aria-label="Status select" required>
                    <option value="vacation">vacation</option>
                    <option value="marriage">marriage</option>
                    <option value="birthday">birthday</option>
                    <option value="maternity">maternity</option>
                  </select>
                </div>
                <!-- Start Shift -->
                <div class="mb-3">
                  <label for="start-date" class="col-form-label">Start date:</label>
                  <input name="start-date" id="start-date" class="form-control" min="<?php echo date("Y-m-d"); ?>" type="date" required>
                </div>
                <!-- End Shift -->
                <div class="mb-3">
                  <label for="end-date" class="col-form-label">End date:</label>
                  <input name="end-date" id="end-date" class="form-control" min="<?php echo date("Y-m-d"); ?>" type="date" required>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Add time off request</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </section>
    <?php endif; ?>
  </main>
  
  <!-- Links JS -->
  <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="./assets/fullcalendar/dist/index.global.min.js"></script>
  <script src="./assets/js/time-off-request.js"></script>
  <script>
    'use strict';
  </script>
</body>
</html>