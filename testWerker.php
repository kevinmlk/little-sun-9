
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./assets/css/reset.css">
<link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="./assets/css/style.css">
<title>Dashboard | Little Sun</title>
</head>
<body>
<nav>
  <!-- Navbar content -->
</nav>
<main class="container mt-5 pt-5">
  <h1>Welcome back, <?php echo $_SESSION['name']; ?>!</h1>
  <h2>Your Tasks:</h2>
  <?php if (!empty($tasks)): ?>
    <ul>
      <?php foreach ($tasks as $task): ?>
        <li><?= htmlspecialchars($task['TaskName']) ?> (Task ID: <?= $task['TaskID'] ?>)</li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p>You have no tasks assigned.</p>
  <?php endif; ?>
</main>
<script src="./assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
