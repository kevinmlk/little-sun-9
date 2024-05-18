<?php
  // Include bootstrap
  include_once(__DIR__ . '/bootstrap.php');

  // Check if the user is logged in
  session_start();
  if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
  }

  // Show all locations
  $locations = Location::getAllHubs();

  // Show all managers
  $users = User::getAllUsers();

  $managers = [];

  foreach ($users as $u) {
    if ($u['RoleName'] === 'Manager') {
      $managers[] = $u;
    }
  }

  // Array to store rows with ManagerId 3
  $managerHubs = [];

  // Loop through the array and store rows where ManagerId is 3
  // foreach ($locations as $l) {
  //   if ($l['ManagerId'] === $_SESSION['id']) {
  //       $managerHubs[] = $l;
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
  <title>Hubs overview | Little Sun Shiftplanner</title>
</head>
<body>
  <!-- Start Navbar -->
  <nav class="navbar bg-dark border-bottom border-body sticky-top mb-5" data-bs-theme="dark">
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
              <a class="nav-link" href="users.php">Users Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Hubs Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="tasks.php">Tasks Overview</a>
            </li>
            <hr>
            <?php endif; ?>
            <li class="nav-item">
              <a class="nav-link" href="calendar.php">Calendar</a>
            </li>
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
    <ul class="nav nav-tabs mt-5">
      <li class="nav-item">
        <a id="tab-link-hubs" class="nav-link active" href="#hubs-section">Hubs</a>
      </li>
      <li class="nav-item">
        <a id="tab-link-managers" class="nav-link" href="#managers-section">Managers</a>
      </li>
    </ul>

    <!-- All Hubs Section -->
    <section id="hubs-section" class="mt-5">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>All hubs overview</h2>
        <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#createHubModal"><i class="bi bi-house-add me-2"></i>Create hub</button>
      </div>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col"><strong>Hub name</strong></th>
            <th scope="col"><strong>Location</strong></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($locations as $l): ?>
            <tr>
              <th scope="row"><a href="hub-details.php?id=<?php echo $l['Id']; ?>"><?php echo $l['Hubname']; ?></a></th>
              <td><?php echo $l['Hublocation']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <!-- createHubModal -->
      <div class="modal fade" id="createHubModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createHubModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Create hub</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="./includes/add-hub.inc.php" method="post">
                <!-- Hub Name Input-->
                <div class="mb-3">
                  <label for="hub-name" class="form-label">Hub name:</label>
                  <input class="form-control form-control-lg" type="text" name="hub-name" placeholder="Name" required>
                </div>
                <!-- Hub Location Input -->
                <div class="mb-3">
                  <label for="hub-location" class="form-label">Hub location:</label>
                  <input class="form-control form-control-lg" type="text" name="hub-location" placeholder="Location" required>
                </div>
                <!-- Submit Button -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Add new hub</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="managers-section" class="mt-5 d-none">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Managers</h2>
        <div class="d-flex gap-4">
          <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#createManagerModal"><i class="bi bi-person-add me-2"></i>Create manager</button>
          <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#resetPasswordModal"><i class="bi bi-pencil-square me-2"></i>Reset password</button>
        </div>
      </div>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col"><strong>Firstname</strong></th>
            <th scope="col"><strong>Lastname</strong></th>
            <th scope="col"><strong>Email</strong></th>
            <th scope="col"><strong>Hub</strong></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($managers as $m): ?>
            <tr>
              <td><?php echo $m['Firstname'];?></td>
              <td><?php echo $m['Lastname'];?></td>
              <td><?php echo $m['Email']; ?></td>
              <td><?php echo $m['Hubname']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <!-- createManagerModal -->
      <div class="modal fade" id="createManagerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createManagerModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Create manager</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="./includes/add-manager.inc.php" method="post" enctype="multipart/form-data">
                <!-- Manager Firstname Input-->
                <div class="mb-3">
                  <label for="firstname" class="form-label">Firstname:</label>
                  <input class="form-control form-control-lg" type="text" name="firstname" placeholder="Firstname" required>
                </div>
                <!-- Manager Lastname Input -->
                <div class="mb-3">
                  <label for="lastname" class="form-label">Lastname:</label>
                  <input class="form-control form-control-lg" type="text" name="lastname" placeholder="Lastname" required>
                </div>
                <!-- Manager Email Input -->
                <div class="mb-3">
                  <label for="email" class="form-label">Email:</label>
                  <input class="form-control form-control-lg" type="email" name="email" placeholder="Email" required>
                </div>
                <!-- Manager Password Input -->
                <div class="mb-3">
                  <label for="password" class="form-label">Password:</label>
                  <input class="form-control form-control-lg" type="password" name="password" placeholder="Password" required>
                </div>
                <!-- Manager Hub Select -->
                <div class="mb-3">
                  <label for="hub-select" class="col-form-label">Choose hub:</label>
                  <select name="hub-select" class="form-select form-select-lg" aria-label="Hub select" required>
                    <?php foreach($locations as $l): ?>
                      <option value="<?php echo $l['Id']; ?>"><?php echo $l['Hubname'];?> (<?php echo $l['Hublocation']; ?>)</option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <!-- Manager Profile Picture Input -->
                <div class="input-group mb-3">
                  <label name="profile-picture" class="input-group-text" for="inputGroupFile01">Upload:</label>
                  <input type="file" class="form-control form-control-lg" name="profile-picture-input" id="inputGroupFile01">
                </div>
                <!-- Submit Button -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Add new manager</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- resetPasswordModal -->
      <div class="modal fade" id="resetPasswordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="restPasswordModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Reset password</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="./includes/reset-password.inc.php" method="post">
                <!-- Manager Hub Select -->
                <div class="mb-3">
                  <label for="manager-select" class="col-form-label">Choose manager:</label>
                  <select name="manager-select" class="form-select form-select-lg" aria-label="Manager select" required>
                    <?php foreach($managers as $m): ?>
                      <option value="<?php echo $m['Id']; ?>"><?php echo $m['Firstname'];?> <?php echo $m['Lastname']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <!-- Manager Password Input -->
                <div class="mb-3">
                  <label for="new-password" class="form-label">New password:</label>
                  <input class="form-control form-control-lg" type="password" name="new-password" placeholder="Password" required>
                </div>
                <!-- Submit Button -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Reset password</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
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
  <script>
    'use strict';

    // Global variables
    const hubsSection = document.querySelector('#hubs-section');
    const managersSection = document.querySelector('#managers-section');
    const hubsTabLink = document.querySelector('#tab-link-hubs');
    const managersTabLink = document.querySelector('#tab-link-managers');

    // Setup function - loads when the DOM content is loaded
    const setup = () => {
      // Event listeners
      hubsTabLink.addEventListener('click', showHubs);
      managersTabLink.addEventListener('click', showManagers);
    }

    const showHubs = () => {
      if (hubsSection.classList.contains('d-none')) {
        managersSection.classList.add('d-none');
        hubsSection.classList.remove('d-none');
        hubsTabLink.classList.add('active');
        managersTabLink.classList.remove('active');
      }
    }

    const showManagers = () => {
      if (managersSection.classList.contains('d-none')) {
        hubsSection.classList.add('d-none');
        managersSection.classList.remove('d-none');
        managersTabLink.classList.add('active');
        hubsTabLink.classList.remove('active');
      }
    }

    // Load setup when the DOM content is loaded
    document.addEventListener('DOMContentLoaded', setup);
  </script>
</body>
</html>