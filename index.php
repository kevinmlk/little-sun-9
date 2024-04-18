<?php
  include_once(__DIR__ . '/bootstrap.php');

  // Check if the user is logged in
  session_start();
  if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
  }
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Links CSS -->
  <link rel="stylesheet" href="./assets/css/reset.css">
  <link rel="stylesheet" href="./assets/css/style.css">
  <!-- Title -->
  <title>Little Sun</title>
</head>
<body>
  <main>
    <h1>Little Sun</h1>
    <h2>Welcome!</h2>
    <a href="logout.php">Hi, logout?</a>
  </main>
  <!-- Links JS -->
  <script src="./assets/js/app.js" ></script>
</body>
</html>