<?php
include_once(__DIR__ . '/../../bootstrap.php');

if (!empty($_POST['employeeId'])) {

  // Get all time off requests from db
  $timeOffRequests = TimeOffRequest::getAllTimeOffRequests();

  $timeOffRequest = [];

  foreach ($timeOffRequests as $tor) {
    if ($tor['EmployeeId'] == $_POST['employeeId']) {
      // $startTime = (new DateTime($tor['StartDate']))->format('Y-m-d');
      // $endTime = (new DateTime($tor['EndDate']))->format('Y-m-d');

      $timeOffRequest[] = [
        'id' => $tor['TimeOffRequestId'],
        'type' => $tor['Type'],	
        'period' => $tor['TimeOffRequestId'] . ' - ' . $tor['StartDate'] . ' - ' . $tor['EndDate'],
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
