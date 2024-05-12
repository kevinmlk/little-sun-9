<?php
include_once(__DIR__ . '/bootstrap.php');
include_once(__DIR__ . '/classes/PTO.php');

session_start();

if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

// Debugging session variables
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

$success = '';
$error = '';

$result = PTO::handleSubmission();
if (strpos($result, 'successfully') !== false) {
    $success = $result;
} else {
    $error = $result;
}

// Fetch all PTO requests
$allRequests = PTO::getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/bootstrap/icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Time Off | Little Sun Shiftplanner</title>
</head>
<body>
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
                        <?php if ($_SESSION['role'] === 'Admin' || $_SESSION['role'] === 'Manager'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="users.php">Users Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="hubs.php">Hubs Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tasks.php">Task Overview</a>
                        </li>
                        <hr>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="calendar.php">Calendar</a>
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

    <main class="container pt-5">
        <div class="mt-5">
            <h2>PTO Requests</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="type" class="form-label">Type of Time Off:</label>
                    <input type="text" id="type" name="type" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date:</label>
                    <input type="datetime-local" id="start_date" name="start_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date:</label>
                    <input type="datetime-local" id="end_date" name="end_date" class="form-control" required>
                </div>
                <button type="submit" name="submit_timeoff" class="btn btn-primary">Submit PTO Request</button>
            </form>

            <?php if ($_SESSION['role'] === 'Manager' || $_SESSION['role'] === 'Admin'): ?>
            <h3 class="mt-5">Approve PTO Requests</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Approved</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allRequests as $request): ?>
                    <tr>
                        <td><?php echo $request['Id']; ?></td>
                        <td><?php echo $request['Firstname'] . ' ' . $request['Lastname']; ?></td>
                        <td><?php echo $request['Type']; ?></td>
                        <td><?php echo $request['StartDate']; ?></td>
                        <td><?php echo $request['EndDate']; ?></td>
                        <td><?php echo $request['Approved'] ? 'Yes' : 'No'; ?></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="request_id" value="<?php echo $request['Id']; ?>">
                                <input type="hidden" name="approved" value="<?php echo $request['Approved'] ? 0 : 1; ?>">
                                <button type="submit" name="approve" class="btn btn-<?php echo $request['Approved'] ? 'danger' : 'success'; ?>">
                                    <?php echo $request['Approved'] ? 'Revoke' : 'Approve'; ?>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </main>

    <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>