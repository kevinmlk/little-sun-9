<?php
  // Include bootstrap
  include_once(__DIR__ . '/bootstrap.php');

  // Start session
  session_start();
  // Check if the logged in user has an admin role
  if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
      // Redirect user to login page or show an error message
      header("Location: index.php");
      exit;
  }
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Links CSS -->
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="./assets/css/style.css">
  <title>Create Hub Locations | Little Sun Shiftplanner</title>
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
              <a class="nav-link" href="create-user.php">Users Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="create-hub.php">Hub Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="tasks.php">Task Overview</a>
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
  <main class="container d-flex justify-content-between align-items-center vh-100">
    <!-- Add Hub Section -->
    <section class="col-4">
      <h1 class="mb-3">Tasks</h1>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Add task type</h2>
        <a href="tasks.php" class="btn btn-primary">Back to overview</a>
      </div>
      <div class="card p-4 mb-3">
        <h1 class="card-title">Add task type</h1>
        <!-- Add Hub Form -->
        <form action="./includes/add-task.inc.php" method="post">
          <!-- Task Type Name Input -->
          <div class="mb-3">
            <label for="task-typ-name" class="form-label">Task type name</label>
            <input class="form-control form-control-lg" type="text" name="task-type-name" placeholder="Task type name" required>
          </div>
          <!-- Submit Button -->
          <div class="d-grid">
            <input type="submit" value="Add task type" class="btn btn-primary">
          </div>
        </form>
      </div>
    </section>
  </main>

  <!-- Links JS -->
  <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="./assets/js/app.js" ></script>
</body>
</html>