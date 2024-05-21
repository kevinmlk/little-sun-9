<?php
  include_once(__DIR__ . '/bootstrap.php');

  // Check if the user is logged in
  session_start();
  if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
  }

  // Show all locations
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

  $currentHub = filterHub($_SESSION['hubId'], $locations);

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
  <title>Dashboard | Little Sun Shiftplanner</title>
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
              <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
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
  <!-- Start main content -->
  <main class="container">
    <h1>Welcome back <?php echo $_SESSION['name']; ?>!</h1>
    <h2>Dashboard</h2>
  </main>
  <!-- Links JS -->
  <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="./assets/fullcalendar/dist/index.global.min.js"></script>
  <script>
    
  </script>
</body>
</html>