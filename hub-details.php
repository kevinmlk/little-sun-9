<?php
  // Include bootstrap
  include_once(__DIR__ . '/bootstrap.php');

  // Check if the user is logged in
  session_start();
  if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
  }

  // Controleert of dat er een id werd meegegeven
  if (!isset($_GET['id'])) {
    exit('404 - not found');
  } else {
    // Get the id from the URL with $_GET
    $id = $_GET['id'];
  }

  // $id = $_GET['id'];

  // Toon alle hubs
  $locations = Location::getAllHubs();

  // Loop through the array
  function filterHub($hubId, $hubs) {
    foreach ($hubs as $h) {
      if ($h['Id'] == $hubId) {
          $hub = $h;
          return $hub;
      }
    }
  }

  function getManager($hub, $users) {
    foreach ($users as $u) {
      if ($u['Hubname'] === $hub['Hubname'] && $u['RoleName'] === 'Manager') {
        $hubManager = $u;
        return $hubManager;
      }
    }
  }

  $currentHub = filterHub($id, $locations);

  // Get all the employees of the current hub
  $users = User::getAllUsers();

  $employees = [];

  foreach ($users as $u) {
    if ($u['Hubname'] === $currentHub['Hubname'] && $u['RoleName'] === 'Employee') {
      $employees[] = $u;
    }
  }

  $hubManager = getManager($currentHub, $users);

  // Get all the tasks
  $tasks = Task::getAllTaskTypes();

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Links CSS -->
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="./assets/bootstrap/icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./assets/css/style.css">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="./assets/images/favicon_io/favicon.ico">
  <title><?php echo $currentHub['Hubname']; ?> | Little Sun Shiftplanner</title>
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
              <a class="nav-link active" aria-current="page" href="#">Hubs Overview</a>
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
              <a class="nav-link active" aria-current="page" href="hub-details.php?id=<?php echo $currentHub['Id']; ?>">Hub Overview</a>
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
              <a class="nav-link" href="time-off-requests.php">Time Off Requests</a>
            </li>
          </ul>
          <a class="btn btn-outline-success mt-5" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="container d-flex flex-column">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1><?php echo $currentHub['Hubname']; ?> information</h1>
      <?php if ($_SESSION['role'] === 'Admin'): ?>
      <a href="hubs.php" class="btn btn-primary">Back to overview</a>
      <?php endif; ?>
    </div>

    <ul class="nav nav-tabs mt-5">
      <li class="nav-item">
        <a id="tab-link-employees" class="nav-link active" href="#employees-section">Employees</a>
      </li>
      <li class="nav-item">
        <a id="tab-link-hub-settings" class="nav-link" href="#hub-settings-section">Hub settings</a>
      </li>
    </ul>

    <!-- Employees List -->
    <section id="employees-section" class="mt-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Employees</h2>
        <div>
          <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#createEmployeeModal"><i class="bi bi-person-add me-2"></i>Create employee</button>
          <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#assignTaskModal"><i class="bi bi-file-plus me-2"></i>Assign task</button>
        </div>
      </div>
      <!-- Employee Table -->
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col"><strong>Firstname</strong></th>
            <th scope="col"><strong>Lastname</strong></th>
            <th scope="col"><strong>Task</strong></th>
            <th scope="col"><strong>Email</strong></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($employees as $e): ?>
            <tr>
              <th scope="row"><?php echo $e['Firstname']; ?></th>
              <td><?php echo $e['Lastname']; ?></td>
              <td><?php echo $e['Taskname']; ?></td>
              <td><?php echo $e['Email']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <!-- Manager Table -->
      <h2 class="mt-5">Hub manager</h2>
      <table class="table table-striped table-hover mt-3">
        <thead>
          <tr>
            <th scope="col"><strong>Firstname</strong></th>
            <th scope="col"><strong>Lastname</strong></th>
            <th scope="col"><strong>Email</strong></th>
          </tr>
        </thead>
        <?php if (!empty($hubManager)): ?>
        <tbody>
            <tr>
              <th scope="row"><?php echo $hubManager['Firstname']; ?></th>
              <td><?php echo $hubManager['Lastname']; ?></td>
              <td><?php echo $hubManager['Email']; ?></td>
            </tr>
        </tbody>
        <?php endif; ?>
      </table>

      <!-- createEmployeeModal -->
      <div class="modal fade" id="createEmployeeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createEmployeeModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Create employee</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="./includes/add-employee.inc.php" method="post" enctype="multipart/form-data">
                <!-- Employee Firstname Input-->
                <div class="mb-3">
                  <label for="firstname" class="form-label">Firstname:</label>
                  <input class="form-control form-control-lg" type="text" name="firstname" placeholder="Firstname" required>
                </div>
                <!-- Employee Lastname Input -->
                <div class="mb-3">
                  <label for="lastname" class="form-label">Lastname:</label>
                  <input class="form-control form-control-lg" type="text" name="lastname" placeholder="Lastname" required>
                </div>
                <!-- Employee Email Input -->
                <div class="mb-3">
                  <label for="email" class="form-label">Email:</label>
                  <input class="form-control form-control-lg" type="email" name="email" placeholder="Email" required>
                </div>
                <!-- Employee Password Input -->
                <div class="mb-3">
                  <label for="password" class="form-label">Password:</label>
                  <input class="form-control form-control-lg" type="password" name="password" placeholder="Password" required>
                </div>
                <!-- Employee Hub -->
                <div class="mb-3">
                  <label for="current-hub" class="form-label">Hub:</label>
                  <input type="text" name="current-hub" class="form-control form-control-lg" value="<?php echo $currentHub['Hubname']; ?>" disabled>
                  <input type="text" name="hub-input" class="form-control form-control-lg d-none" value="<?php echo $currentHub['Id']; ?>">
                </div>
                <!-- Employee Profile Picture Input -->
                <div class="input-group mb-3">
                  <label name="profile-picture" class="input-group-text" for="inputGroupFile01">Upload:</label>
                  <input type="file" class="form-control form-control-lg" name="profile-picture-input" id="inputGroupFile01">
                </div>
                <!-- Submit Button -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Add new employee</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- assignTaskModal -->
      <div class="modal fade" id="assignTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="assignTaskModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Assign task</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="./includes/assign-task.inc.php" method="post">
                <!-- Employee Select -->
                <div class="mb-3">
                  <label for="employee-select" class="form-label">Choose employee:</label>
                  <select class="form-select form-select-lg" name="employee-select">
                    <?php foreach ($employees as $e): ?>
                    <option value="<?php echo $e['Id']; ?>"><?php echo $e['Firstname'] . ' ' . $e['Lastname']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <!-- Task Select -->
                <div class="mb-3">
                  <label for="task-select" class="form-label">Choose task:</label>
                  <select class="form-select form-select-lg" name="task-select">
                    <?php foreach ($tasks as $t): ?>
                    <option value="<?php echo $t['Id']; ?>"><?php echo $t['Taskname']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <!-- Submit Button -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Assign task</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Hub Settings Section -->
    <section id="hub-settings-section" class="mt-5 d-none">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Hub settings</h2>
        <?php if ($_SESSION['role'] === 'Admin'): ?>
        <div class="d-flex gap-4">
          <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#editHubModal"><i class="bi bi-pencil-square me-2"></i>Edit hub</button>
          <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#deleteHubModal"><i class="bi bi-trash me-2"></i>Delete hub</button>
        </div>
        <?php endif; ?>
      </div>        
      
      <!-- Hub Settings Table -->
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col"><strong>Name</strong></th>
            <th scope="col"><strong>Location</strong></th>
            <?php if (!empty($hubManager)): ?>
            <th scope="col"><strong>Manager</strong></th>
            <?php endif; ?>
            <th scope="col"><strong>Employees</strong></th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <th scope="row"><?php echo $currentHub['Hubname']; ?></th>
              <td><?php echo $currentHub['Hublocation']; ?></td>
              <?php if (!empty($hubManager)): ?>
              <td><?php echo $hubManager['Firstname']; ?> <?php echo $hubManager['Lastname']; ?></td>
              <?php endif; ?>
              <td><?php echo count($employees); ?></td>
            </tr>
        </tbody>
      </table>

      <!-- editHubModal -->
      <div class="modal fade" id="editHubModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editHubModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit hub</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="./includes/edit-hub.inc.php" method="post">
                <!-- Hub Name Input -->
                <div class="mb-3">
                  <label for="new-hub-name" class="form-label">Hub name:</label>
                  <input type="text" name="new-hub-name" class="form-control form-control-lg" placeholder="<?php echo $currentHub['Hubname']; ?>" required>
                  <input type="text" name="hub-input" class="form-control form-control-lg d-none" value="<?php echo $currentHub['Id']; ?>">
                </div>
                <!-- Hub Location Input -->
                <div class="mb-3">
                  <label for="new-hub-location" class="form-label">Hub location:</label>
                  <input type="text" name="new-hub-location" class="form-control form-control-lg" placeholder="<?php echo $currentHub['Hublocation']; ?>" required>
                </div>
                <!-- Submit Button -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Edit hub</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- deleteHubModal -->
      <div class="modal fade" id="deleteHubModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteHubModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete hub</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this hub?</p>
              <form action="./includes/delete-hub.inc.php" method="post">
                <input type="text" name="hub-input" class="form-control form-control-lg d-none" value="<?php echo $currentHub['Id']; ?>">
                <!-- Submit Button -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Delete hub</button>
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
  <script>
    'use strict';

    // Global variables
    const employeeSection = document.querySelector('#employees-section');
    const hubSettingsSection = document.querySelector('#hub-settings-section');
    const employeesTabLink = document.querySelector('#tab-link-employees');
    const hubSettingsTabLink = document.querySelector('#tab-link-hub-settings');

    // Setup function - loads when the DOM content is loaded
    const setup = () => {
      // Event listeners
      employeesTabLink.addEventListener('click', showEmployees);
      hubSettingsTabLink.addEventListener('click', showHubSettings);
    }

    const showEmployees = () => {
      if (employeeSection.classList.contains('d-none')) {
        hubSettingsSection.classList.add('d-none');
        employeeSection.classList.remove('d-none');
        employeesTabLink.classList.add('active');
        hubSettingsTabLink.classList.remove('active');
      }
    }

    const showHubSettings = () => {
      if (hubSettingsSection.classList.contains('d-none')) {
        employeeSection.classList.add('d-none');
        hubSettingsSection.classList.remove('d-none');
        hubSettingsTabLink.classList.add('active');
        employeesTabLink.classList.remove('active');
      }
    }

    // Load setup when the DOM content is loaded
    document.addEventListener('DOMContentLoaded', setup);
  </script>
</body>
</html>