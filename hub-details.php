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

  $currentHub = filterHub($id, $locations);

  // Shifts
  $shifts = Shift::getAllShifts();

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
              <a class="nav-link active" aria-current="page" href="create-hub.php">Hub Overview</a>
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
  <main class="container pt-5 d-flex flex-column">
    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
      <h1>Hub information</h1>
      <a href="hubs.php" class="btn btn-primary">Back to overview</a>
    </div>
    
    <div>
      <!-- User list -->
      <section class="mt-5">
        <h2 class="mb-3">Employees</h2>

        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th scope="col"><strong>Employee name</strong></th>
              <th scope="col"><strong>Task</strong></th>
              <th scope="col"><strong>Hub</strong></th>
              <th scope="col"><strong>Location</strong></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($shifts as $s): ?>
              <tr>
                <th scope="row"><?php echo $s['Firstname']; ?> <?php echo $s['Lastname']; ?></a></th>
                <td><?php echo $s['Taskname']; ?></td>
                <td><?php echo $s['Hubname']; ?></td>
                <td><?php echo $s['Hublocation']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </section>
    </div>

    <div class="mt-5">
      <h2>Hub settings</h2>
      <div class="d-flex gap-5 mt-5 align-items-top">
        <!-- Add Employee Section -->
        <section class="col-4">
          <div class="card p-4 mb-3">
            <h3 class="card-title">Add employee to current hub</h3>
            <!-- Error message -->
            <?php if (isset($error)): ?>
            <div>
              <p><?php echo $error; ?></p>
            </div>
            <?php endif; ?>
            <!-- Add User Form -->
            <form action="./includes/add-employee.inc.php" method="post" class="login-form" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="firstname" class="form-label">Firstname</label>
                <input class="form-control form-control-lg" type="text" name="firstname" placeholder="Firstname">
              </div>
    
              <div class="mb-3">
                <label for="lastname" class="form-label">Lastname</label>
                <input class="form-control form-control-lg" type="text" name="lastname" placeholder="Lastname">
              </div>
    
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input class="form-control form-control-lg" type="email" name="email" placeholder="Email">
              </div>
              <!-- Password Input -->
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input class="form-control form-control-lg" type="password" name="password" placeholder="Password">
              </div>
              <!-- Roles Input -->
              <div class="mb-3 visually-hidden">
                <label for="role" class="form-label">Role</label>
                <input class="form-control form-control-lg" type="text" name="role" placeholder="Employee" value="Employee">
              </div>
              <!-- Location Input -->
              <div class="mb-3 visually-hidden">
                <label for="location" class="form-label">Location</label>
                <input class="form-control form-control-lg" type="text" name="location" placeholder="<?php echo $id; ?>" value="<?php echo $id; ?>">
              </div>
              <!-- Profile Picture Input -->
              <div class="input-group mb-3">
                <label name="profile-picture" class="input-group-text" for="inputGroupFile01">Upload</label>
                <input type="file" class="form-control form-control-lg" name="profile-picture-input" id="inputGroupFile01">
              </div>
    
              <!-- Submit Button -->
              <div class="d-grid">
                <input type="submit" value="Add user" class="btn btn-primary">
              </div>
            </form>
          </div>
        </section>
    
        <!-- Edit Hub Location -->
        <section class=" col-4 pt-5 mt-5">
          <div class="card p-4 mb-3">
            <h3 class="card-title">Edit hub location</h3>
            <!-- Edit Hub Form -->
            <form action="./includes/edit-hub.inc.php" method="post">
                <!-- Hub Name Input -->
                <div class="mb-3">
                    <label for="new-hub-name" class="form-label">Hub name</label>
                    <input class="form-control form-control-lg" type="text" name="new-hub-name" placeholder="<?php echo $currentHub['Hubname']; ?>" required>
                </div>
                <!-- Hub Location Input -->
                <div class="mb-3">
                    <label for="new-hub-location" class="form-label">Hub location</label>
                    <input class="form-control form-control-lg" type="text" name="new-hub-location" placeholder="<?php echo $currentHub['Hublocation']; ?>" required>
                </div>
                <!-- Submit Button -->
                <div class="">
                    <input type="submit" value="Edit hub" class="btn btn-primary">
                    <input type="submit" value="Delete hub" class="btn btn-secondary">
                </div>
            </form>
          </div>
        </section>
      </div>
    </div>
  </main>
  
  <!-- Links JS -->
  <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="./assets/js/app.js" ></script>
</body>
</html>