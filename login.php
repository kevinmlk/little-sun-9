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
      session_start();
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
  <!-- Tab Title -->
  <title>Login | Little Sun Shiftplanner</title>
</head>
<body class="bg-image d-flex flex-column vh-100">
  <!-- Navigation -->
  <nav class="container navbar bg-body-tertiary mt-4">
    <div class="container-fluid">
      <a class="navbar-brand">Little Sun</a>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Button</button>
      </form>
    </div>
  </nav>
  <!-- Main Content -->
  <main class="container d-flex justify-content-between align-items-center vh-100">
    <!-- Intro Text -->
    <section class="col-5">
      <h1>Little Sun Shifplanner</h1>
      <p class="lh-base">
        Welcome to Little Sun Shiftplanner, the ultimate platform fro shift planner in Zambia!
        At Little Sun Shiftplanner, we empower workers to take control of their schedules by
        defining their roles and selecting preferred work locations. Our user-friendly interface
        allows workers to plan their availability for shifts and even schedule well-deserved
        vacations with ease.
      </p>
    </section>

    <!-- Login Form -->
    <section class="col-4">
      <div class="card p-4 mb-3">
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
      <!-- Extra links -->
      <ul class="text-center">
        <li><a href="" class="link-light">Forgot password?</a></li>
        <li><a href="" class="link-light">Don't have an account?</a></li>
      </ul>
    </section>
  </main>

  <!-- Links JS -->
  <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="./assets/js/app.js" ></script>
</body>
</html>