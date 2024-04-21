<?php
  include_once(__DIR__ . '/bootstrap.php');


  session_start();

  if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    // Redirect user to login page or show an error message
    header("Location: index.php");
    exit;
  }
  

  if (!empty($_POST)) {
    $user = new User();
    $user->setFirstname($_POST['firstname']);
    $user->setLastname($_POST['lastname']);
    $user->setEmail($_POST['email']);
    $user->setPassword($_POST['password']);
    $user->setRole($_POST['roles']);

    // Run create user method
    $user->createUser();
    echo 'User added!';
  }

  // Toon alle gebruikers
  $users = User::getAllUsers();
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Links CSS -->
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="./assets/css/style.css">
  <title>Shiftplanner - Create User</title>
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
              <a class="nav-link active" aria-current="page" href="create-user.php">Users Overview</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="create-hub.php">Hub Overview</a>
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
  <!-- Start Main Content -->
  <main class="container d-flex justify-content-between align-items-center vh-100">
    <section class="col-4">
      <div class="card p-4 mb-3">
        <h1 class="card-title">Create User</h1>
      <!-- Add User Form -->
      <form action="create-user.php" method="post" class="login-form">
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
        <!-- Roles Select -->
        <div class="mb-3">
          <label for="roles">Choose a role</label>
          <select name="roles" class="form-select">
            <option value="Admin">Admin</option>
            <option value="Employee">Employee</option>
            <option value="Manager">Manager</option>
          </select>
        </div>
        <!-- Submit Button -->
        <div class="d-grid">
          <input type="submit" value="Add user" class="btn btn-primary">
        </div>
      </form>

      <div>
        <h2>Users:</h2>
        <?php foreach ($users as $user): ?>
          <span><?php echo $user['Firstname']; ?></span>
        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <!-- Links JS -->
  <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="./assets/js/app.js" ></script>
</body>
</html>