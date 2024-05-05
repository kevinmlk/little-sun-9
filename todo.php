<?php
include_once(__DIR__ . '/bootstrap.php');

session_start();

// Redirect if the user is not logged in as a Manager or Admin
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Manager' && $_SESSION['role'] !== 'Admin')) {
    header("Location: index.php");
    exit;
}

// Fetch all assigned tasks
$tasks = Task::getAllAssignedTasks(); // This now uses the newly implemented method

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Links CSS -->
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="./assets/css/style.css">
  <title>To Do | Little Sun Shiftplanner</title>
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
            <?php if ($_SESSION['role'] === 'Admin'): ?>
            <li class="nav-item">
              <a class="nav-link" href="users.php">Users Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Hubs Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="tasks.php">Task Overview</a>
            </li>
            <?php endif; ?>
            <hr>
            <li class="nav-item">
              <a class="nav-link" href="#">Calendar</a>
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
    <section class="mt-5">
    <h1 class="mb-3">To Do</h1>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Overview of all assigned tasks</h2>
        <a href="assign-task.php" class="btn btn-primary">Assign Task</a>
      </div>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Task</th>
            <th scope="col">Assigned worker</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($tasks as $task): ?>
            <tr>
              <td><?php echo htmlspecialchars($task['TaskID']); ?></td>
              <td><?php echo htmlspecialchars($task['TaskName']); ?></td>
              <td><?php echo htmlspecialchars($task['Firstname'] . ' ' . $task['Lastname']); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </main>
  
  <!-- Links JS -->
  <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="./assets/js/app.js"></script>
</body>
</html>