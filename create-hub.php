<?php
    // Include bootstrap
    include_once(__DIR__ . '/bootstrap.php');

    // Start session
    session_start();
    // Check if the logged in user has an admin role
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
        // Redirect user to login page or show an error message
        header("Location: index.php");
        exit;
    }

    // Checks if a form has been sent
    if (!empty($_POST)) {
        $location = new Location();
        $location->setHubName($_POST['hub-name']);
        $location->setHubLocation($_POST['hub-location']);

        // Run create user method
        $location->addHubLocation();
    }

    // Toon alle gebruikers
    $locations = Location::getAllHubs();
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
<!-- Main Content -->
<main class="container d-flex justify-content-between align-items-center vh-100">
    <!-- Add Hub Section -->
    <section class="col-4">
      <div class="card p-4 mb-3">
        <h1 class="card-title">Add a hub location</h1>
        <!-- Login form -->
        <form action="create-hub.php" method="post">
          <!-- Hub Name Input -->
          <div class="mb-3">
            <label for="email" class="form-label">Hub name</label>
            <input class="form-control form-control-lg" type="text" name="hub-name" placeholder="Name" required>
          </div>
          <!-- Hub Location Input -->
          <div class="mb-3">
            <label for="password" class="form-label">Hub location</label>
            <input class="form-control form-control-lg" type="text" name="hub-location" placeholder="Location" required>
          </div>
          <!-- Submit Button -->
          <div class="d-grid">
            <input type="submit" value="Add hub" class="btn btn-primary">
          </div>
        </form>
      </div>
    </section>

    <!-- Hub Overview Section -->
    <section>
    <div class="card p-4 mb-3">
        <h1 class="card-title">All hub locations</h1>
        <!-- Hub Overview Form -->
        <form action="create-hub.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Hub overview</label>
                <select class="form-select" size="5" aria-label="Size 3 select example">
                    <?php foreach($locations as $location): ?>
                    <option value="<?php echo $location['Hubname']; ?>">Name: <?php echo $location['Hubname'];?>, Location: <?php echo $location['Hublocation']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Submit Button -->
            <div class="d-grid">
                <input type="submit" value="Remove hub" class="btn btn-primary">
            </div>
        </form>
      </div>
    </section>

    <!-- Edit/Remove Hub Section -->
    <section>
        <div class="card p-4 mb-3">
            <h1 class="card-title">Edit hub location</h1>
            <!-- Edit Hub Form -->
            <form action="create-hub.php" method="post">
                <!-- Hub Locations Selection -->
                <div class="mb-3">
                    <label for="roles" class="form-label">Choose a hub</label>
                    <select class="form-select" aria-label="Default select example">
                        <?php foreach($locations as $location): ?>
                        <option value="<?php echo $location['Hubname']; ?>"><?php echo $location['Hubname']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Hub Name Input -->
                <div class="mb-3">
                    <label for="email" class="form-label">Hub name</label>
                    <input class="form-control form-control-lg" type="text" name="hub-name" placeholder="Name" required>
                </div>
                <!-- Hub Location Input -->
                <div class="mb-3">
                    <label for="password" class="form-label">Hub location</label>
                    <input class="form-control form-control-lg" type="text" name="hub-location" placeholder="Location" required>
                </div>
                <!-- Submit Button -->
                <div class="d-grid">
                    <input type="submit" value="Edit hub" class="btn btn-primary">
                </div>
            </form>
        </div>
    </section>
  </main>

  <!-- Links JS -->
  <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
  <script src="./assets/js/app.js" ></script>
</body>
</html>