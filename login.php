<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Links CSS -->
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/style.css">
  <title>Shiftplanner - Login</title>
</head>
<body>
  <main class="bg-image">
    <section class="card-login">
      <h1>Login</h1>
      <p>Use your Little Sun account to login</p>
      <!-- Login form -->
      <form action="login.php" method="post" class="login-form">
        <div class="form-field">
          <input class="input-field" type="text" name="email-phone" placeholder="Email or phone">
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