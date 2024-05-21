<?php
include_once(__DIR__ . '/../../bootstrap.php');

if (!empty($_POST['employeeId'])) {

  // Get all time off requests from db
  $timeOffRequests = TimeOffRequest::getAllTimeOffRequests();

  $timeOffRequest = [];

  $date = $_POST['startTime'];
  $date = $date->format('Y-m-d');

  foreach ($timeOffRequests as $tor) {
    // $startTime = (new DateTime($tor['StartDate']))->format('Y-m-d');
    if ($tor['EmployeeId'] == $_POST['employeeId'] && $tor['Status'] == 'approved') {

      $timeOffRequest[] = [
        // 'Id' => $tor['TimeOffRequestId'],
        // 'StartDate' => $startTime,
        'Status' => $tor['Status'],
      ];
    }
  }

    // Return array of employees
    $response = [
        'status' => 'success',
        'body' => $timeOffRequest,
        'message' => 'Employee time off retrieved',
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'EmployeeId is missing',
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
