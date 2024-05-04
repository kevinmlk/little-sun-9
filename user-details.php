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
    // echo $id;
  }

  $id = $_GET['id'];

  // Toon alle hubs
  $users = User::getAllUsers();

  $user = $users[$id];
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Links CSS -->
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="./assets/css/style.css">
  <title><?php echo $user['Firstname']; ?> <?php echo $user['Lastname']; ?> Profile | Little Sun Shiftplanner</title>
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
              <a class="nav-link active" aria-current="page" href="users.php">Users Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="hubs.php">Hubs Overview</a>
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
    <!-- Edit Hub Section -->
    <!-- Edit User Password Section -->
    <section>
      <div class="card p-4 mb-3">
        <h1 class="card-title">Edit User Password</h1>
        <!-- Edit Hub Form -->
        <form action="./includes/edit-user.inc.php" method="post">
          <!-- Hub Locations Selection -->
          <div class="mb-3">
            <label for="user-select" class="form-label">Choose User</label>
            <select name="user-select" class="form-select form-control-lg" aria-label="Default select example">
              <?php foreach ($users as $user): ?>
              <option value="<?php echo $user['Firstname']; ?>"><?php echo $user['Firstname']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <!-- Hub Name Input -->
          <div class="mb-3">
            <label for="new-password" class="form-label">New Password</label>
            <input class="form-control form-control-lg" type="password" name="new-password" placeholder="New Password" required>
          </div>
          <!-- Submit Button -->
          <div class="d-grid">
            <input type="submit" value="Edit password" class="btn btn-primary">
          </div>
        </form>
      </div>
    </section>
    <section class="mt-5">
      <h1 class="mb-3"><?php echo $user['Firstname']; ?></h1>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2>Hub information</h2>
          <a href="users.php" class="btn btn-primary">Back to overview</a>
        </div>
        <div class="card p-4 mb-3">
            <h1 class="card-title">Edit hub location</h1>
            <!-- Edit Hub Form -->
            <form action="./includes/edit-hub.inc.php" method="post">
                <!-- Hub Name Input -->
                <div class="mb-3">
                    <label for="new-hub-name" class="form-label">Hub name</label>
                    <input class="form-control form-control-lg" type="text" name="new-hub-name" placeholder="<?php echo $user['Firstname']; ?>" required>
                </div>
                <!-- Hub Location Input -->
                <div class="mb-3">
                    <label for="new-hub-location" class="form-label">Hub location</label>
                    <input class="form-control form-control-lg" type="text" name="new-hub-location" placeholder="<?php echo $user['Lastname']; ?>" required>
                </div>
                <!-- Submit Button -->
                <div class="">
                    <input type="submit" value="Edit hub" class="btn btn-primary">
                    <input type="submit" value="Delete hub" class="btn btn-secondary">
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