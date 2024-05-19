<?php
  // Include bootstrap
  include_once(__DIR__ . '/bootstrap.php');

  

    // Function checks if the employee has a day off on the selected day
    $shifts = Shift::getUserShifts(20);
    $date = '2024-05-16';

    // Iterate through each shift
    foreach ($shifts as $s) {
        // Extract the date from StartTime
        $shiftDate = date("Y-m-d", strtotime($s["StartTime"]));
        // If the task's date is today, add it to $tasksToday array
        if ($shiftDate === date('Y-m-d', strtotime($date))) {
            $error = true;
        }
    }

    print_r($shifts);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if (isset($error)): ?>
        <p>ERRRROORRRR</p>
    <?php endif; ?>

    <!-- <ul class="nav nav-tabs mt-5">
      <li class="nav-item">
        <a id="tab-link-calendar" class="nav-link active" href="#">Calendar</a>
      </li>
      <li class="nav-item">
        <a id="tab-link-task-types" class="nav-link" href="#">Task types</a>
      </li>
    </ul> -->

    <!-- Calendar Section -->
    <section id="calendar-section" class="mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Shift's week overview</h2>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add shift</button>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Add shift</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <!-- Login error message -->
              <?php	if (!empty($error)): ?>
              <div class="form-error">
                <p>
                  Sorry, the selected employee has a day off on that day. Select another day to plan the shift.
                </p>
              </div>
              <?php endif; ?>
              <form action="./includes/add-shift.inc.php" method="post">
                <!-- Hub Select -->
                <div class="mb-3">
                  <!-- Manager hub view -->
                  <?php if ($_SESSION['role'] === 'Manager'): ?>
                  <label for="hub-select" class="col-form-label">Choose hub:</label>
                  <select name="hub-select" class="form-select" aria-label="Hub select" required>
                    <?php foreach($managerHubs as $h): ?>
                      <option value="<?php echo $h['Id']; ?>"><?php echo $h['Hubname'];?> (<?php echo $h['Hublocation']; ?>)</option>
                    <?php endforeach; ?>
                  </select>
                  <?php endif; ?>

                  <!-- Admin hub view -->
                  <?php if ($_SESSION['role'] === 'Admin'): ?>
                  <label for="hub-select" class="col-form-label">Choose hub:</label>
                  <select name="hub-select" class="form-select" aria-label="Hub select" required>
                    <?php foreach($locations as $l): ?>
                      <option value="<?php echo $l['Id']; ?>"><?php echo $l['Hubname'];?> (<?php echo $l['Hublocation']; ?>)</option>
                    <?php endforeach; ?>
                  </select> 
                  <?php endif; ?>
                </div>
                <!-- Employee Select -->
                <div class="mb-3">
                  <label for="employee-select" class="col-form-label">Choose an employee from hub:</label>
                  <select name="employee-select" class="form-select" aria-label="Employee select" required>
                    <?php foreach($employees as $e): ?>
                      <option value="<?php echo $e['Id']; ?>"><?php echo $e['Firstname'];?> <?php echo $e['Lastname']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <!-- Task -->
                <div class="mb-3">
                  <label for="task-select" class="col-form-label">Assign task:</label>
                  <select name="task-select" class="form-select" aria-label="Task select" required>
                    <?php foreach($tasks as $t): ?>
                      <option value="<?php echo $t['Id']; ?>"><?php echo $t['Taskname'];?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <!-- Start Shift -->
                <div class="mb-3">
                  <label for="start-time" class="col-form-label">Start shift:</label>
                  <input name="start-time" id="start-time" class="form-control" min="<?php echo date("Y-m-d\TH:i"); ?>" type="datetime-local" required>
                </div>
                <!-- End Shift -->
                <div class="mb-3">
                  <label for="end-time" class="col-form-label">End shift:</label>
                  <input name="end-time" class="form-control" min="<?php echo date("Y-m-d\TH:i"); ?>" type="datetime-local" required>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Add new shift</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div id="calendar"></div>
    </section>
</body>
</html>
