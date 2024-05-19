<?php
  // Include bootstrap
  include_once(__DIR__ . '/bootstrap.php');
  // Check if the user is logged in
  session_start();
  if (isset($_SESSION['loggedin'])) {
    header('Location: index.php');
  }

  // Check if theres a login attempt
  if (!empty($_POST)) {
    $user = new User();
    $user->setEmail($_POST['email']);
    $user->setPassword($_POST['password']);

    if ($user->loginUser()) {
      $_SESSION['loggedin'] = true;
			header('Location: index.php');
    } else {
      $error = true;
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
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="./assets/images/favicon_io/favicon.ico">
  <!-- Tab Title -->
  <title>Login | Little Sun Shiftplanner</title>
</head>
<body class="bg-image d-flex flex-column vh-100">
  <!-- Navigation -->
  <nav id="login-navbar" class="container-fluid navbar bg-body-tertiary">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-3" href="index.php">
        <img src="./assets/images/sun.png" alt="Little Sun Logo">
        <p class="fs-3 mb-0">Little Sun</p>
      </a>
    </div>
  </nav>
  <!-- Main Content -->
  <main class="container d-flex justify-content-between align-items-center vh-100">
    <!-- Intro Text -->
    <section id="login-intro" class="col-5">
      <h1 class="mb-3">Little Sun Shiftplanner</h1>
      <p class="fs-5 lh-base">
        Welcome to Little Sun Shiftplanner, the ultimate shift planning platform in Zambia where we empower workers to take control of their schedules!
      </p>
    </section>

    <!-- Login Form -->
    <section class="col-4">
      <div class="card p-4">
        <h1 class="card-title text-center">Welcome</h1>
        <!-- Login error message -->
        <?php	if (isset($error)): ?>
        <div class="form-error">
          <p>
            Sorry, we can't log you in with that email address and password. Can you try again?
          </p>
        </div>
        <?php endif; ?>
        <!-- Login form -->
        <form action="login.php" method="post">
          <!-- Email Input -->
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input class="form-control form-control-lg" type="text" name="email" placeholder="Email or phone" required>
          </div>
          <!-- Password Input -->
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input class="form-control form-control-lg" type="password" name="password" placeholder="Password" required>
          </div>
          <!-- Submit Button -->
          <div class="d-grid">
            <input type="submit" value="Login" class="btn btn-primary">
          </div>
        </form>
      </div>
    </section>
  </main>

  <!-- Links JS -->
  <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>