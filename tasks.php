<?php
  // Include bootstrap
  include_once(__DIR__ . '/bootstrap.php');

  session_start();

  if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    // Redirect user to login page or show an error message
    header("Location: index.php");
    exit;
  }

  // Get all tasks from db
  $tasks = Task::getAllTaskTypes();

  // Get all hub locations from db
  // $locations = Location::getAllHubs();

  // Array to store rows with ManagerId 3
  // $managerHubs = [];

  // // Loop through the array and store rows where ManagerId is 3
  // foreach ($locations as $l) {
  //   if ($l['ManagerId'] === $_SESSION['id']) {
  //       $managerHubs[] = $l;
  //   }
  // }

  // // Get all employees from db
  // $users = User::getAllUsers();

  // $employees = [];

  // foreach ($users as $u) {
  //   if ($u['RoleName'] === 'Employee') {
  //     $employees[] = $u;
  //   }
  // }

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
  <title>Tasks overview | Little Sun Shiftplanner</title>
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
              <a class="nav-link active" aria-current="page" href="#">Tasks Overview</a>
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
              <a class="nav-link" href="calendar-employee.php">Calendar</a>
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

  <!-- Main Content -->
  <main class="container">
    <!-- Task Types Section -->
    <section id="task-type-section" class="mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All Tasks overview</h2>
        <div>
          <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#createTaskTypeModal"><i class="bi bi-file-plus me-2"></i>Create task type</button>
          <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#deleteTaskTypeModal"><i class="bi bi-trash me-2"></i>Delete task type</button>
        </div>
      </div>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col"><strong>Id</strong></th>
            <th scope="col"><strong>Task type name</strong></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($tasks as $task): ?>
            <tr>
              <th scope="row"><?php echo $task['Id']; ?></th>
              <td><?php echo $task['Taskname']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <!-- createTaskTypeModal -->
      <div class="modal fade" id="createTaskTypeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createTaskTypeModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Create task type</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="./includes/add-task.inc.php" method="post">
                <div class="mb-3">
                  <label for="task-typ-name" class="form-label">Task type name</label>
                  <input class="form-control form-control-lg" type="text" name="task-type-name" placeholder="Task type name" required>
                </div>
                <!-- Submit Button -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Add new task type</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- deleteTaskTypeModal -->
      <div class="modal fade" id="deleteTaskTypeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteTaskTypeModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete task type</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="./includes/delete-task-type.inc.php" method="post">
                <div class="mb-3">
                  <label for="task-typ-select" class="form-label">Choose task type:</label>
                  <select class="form-select form-select-lg" name="task-type-select">
                    <?php foreach ($tasks as $task): ?>
                      <option value="<?php echo $task['Id']; ?>"><?php echo $task['Taskname']; ?></option>
                    <?php endforeach; ?>
                  </select>                  
                </div>
                <!-- Submit Button -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Delete task type</button>
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
        initialView: 'dayGridMonth',
        headerToolbar: {
          left: 'title',
          center: 'timeGridDay,timeGridWeek,dayGridMonth',
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