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
<body>
  <main class="container d-flex">
    <!-- Intro Text -->
    <section>
      <h1>Little Sun Shifplanner</h1>
      <p>
        Welcome to Little Sun Shiftplanner, the ultimate platform fro shift planner in Zambia!
        At Little Sun Shiftplanner, we empower workers to take control of their schedules by
        defining their roles and selecting preferred work locations. Our user-friendly interface
        allows workers to plan their availability for shifts and even schedule well-deserved
        vacations with ease.
      </p>
    </section>

    <!-- Login Form -->
    <section class="card">
      <h1>Welcome</h1>
      <!-- Login error message -->
				<?php	if (isset($error)): ?>
				<div class="form-error">
					<p>
						Sorry, we can't log you in with that email address and password. Can you try again?
					</p>
				</div>
				<?php endif; ?>
        <!-- Login form -->
        <form action="login.php" method="post" class="card">
          <div class="form-field">
            <label for="email">Email</label>
            <input class="input-field" type="text" name="email" placeholder="Email or phone">
            <label for="password">Password</label>
            <input class="input-field" type="password" name="password" placeholder="Password">
          </div>

          <input type="submit" value="Login" class="btn btn-primary">
        </form>
        <!-- Extra links -->
      <ul>
        <li><a href="">Forgot password?</a></li>
        <li><a href="">Don't have an account?</a></li>
      </ul>
      
    </section>
  </main>
</body>
</html>