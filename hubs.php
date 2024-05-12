<?php
  // Include bootstrap
  include_once(__DIR__ . '/bootstrap.php');

  // Check if the user is logged in
  session_start();
  if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
  }

  // Show all users
  $locations = Location::getAllHubs();

  // Array to store rows with ManagerId 3
  $managerHubs = [];

  // Loop through the array and store rows where ManagerId is 3
  foreach ($locations as $l) {
    if ($l['ManagerId'] === $_SESSION['id']) {
        $managerHubs[] = $l;
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
            <?php if ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Manager'): ?>
            <li class="nav-item">
              <a class="nav-link" href="users.php">Users Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Hubs Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="tasks.php">Tasks Overview</a>
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
    <!-- All Hubs Section -->
    <section class="mt-5">
      <h1 class="mb-3">Hubs</h1>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All hubs overview</h2>
        <?php if ($_SESSION['role'] === 'Admin'): ?>
        <a href="create-hub.php" class="btn btn-primary">Add hub location</a>
        <?php endif; ?>
      </div>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col"><strong>Hub name</strong></th>
            <th scope="col"><strong>Location</strong></th>
            <th scope="col"><strong>Manager</strong></th>
          </tr>
        </thead>
        <!-- Show when admin -->
        <?php if ($_SESSION['role'] === 'Admin'): ?>
        <tbody>
          <?php foreach($locations as $key => $location): ?>
            <tr>
              <th scope="row"><a href="hub-details.php?id=<?php echo $key; ?>"><?php echo $location['Hubname']; ?></a></th>
              <td><?php echo $location['Hublocation']; ?></td>
              <td><?php echo $location['Firstname'] . ' ' . $location['Lastname'];?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <?php endif; ?>
        <!-- Show when not admin -->
        <?php if ($_SESSION['role'] !== 'Admin'): ?>
        <tbody>
          <?php foreach($locations as $location): ?>
            <tr>
              <th scope="row"><?php echo $location['Hubname']; ?></th>
              <td><?php echo $location['Hublocation']; ?></td>
              <td><?php echo $location['Firstname'] . ' ' . $location['Lastname'];?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <?php endif; ?>
      </table>
    </section>
    
    <!-- My Hubs Section -->
    <?php if (!empty($managerHubs)): ?>
    <section class="mt-5">
      <h2 class="mb-3">My Hubs</h2>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col"><strong>Hub name</strong></th>
            <th scope="col"><strong>Location</strong></th>
            <th scope="col"><strong>Manager</strong></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($managerHubs as $h): ?>
            <tr>
              <th scope="row"><a href="hub-details.php?id=<?php echo $h['Id']; ?>"><?php echo $h['Hubname']; ?></a></th>
              <td><?php echo $h['Hublocation']; ?></td>
              <td><?php echo $h['Firstname'] . ' ' . $h['Lastname'];?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
    <?php endif; ?>
  </main>
  
  <!-- Links JS -->
  <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="./assets/js/app.js" ></script>
</body>
</html>