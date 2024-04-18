<?php
  include_once(__DIR__ . '/bootstrap.php');

  if (!empty($_POST)) {
    $user = new User();
    $user->setFirstname($_POST['firstname']);
    $user->setLastname($_POST['lastname']);
    $user->setEmail($_POST['email']);

    // Run create user method
    $user->createUser();
    echo 'User added!';
  }
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Links CSS -->
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/style.css">
  <title>Shiftplanner - Create User</title>
</head>
<body>
  <main class="bg-image">
    <section class="card-login">
      <h1>Create User</h1>
      <p>Create an user</p>

      <!-- Login form -->
      <form action="create-user.php" method="post" class="login-form">
        <div class="form-field">
          <input class="input-field" type="text" name="firstname" placeholder="Firstname">
          <input class="input-field" type="text" name="lastname" placeholder="Lastname">
          <input class="input-field" type="email" name="email" placeholder="Email">
          <input class="input-field" type="password" name="password" placeholder="Password">
        </div>

        <input type="submit" value="Login" class="btn btn-primary">
      </form>

      <div id="login-links-container">
        <ul>
          <li><a href="">Help</a></li>
          <li><a href="">Privacy</a></li>
          <li><a href="">Terms</a></li>
        </ul>
      </div>
    </section>

  </main>
</body>
</html>