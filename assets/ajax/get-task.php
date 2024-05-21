<?php
include_once(__DIR__ . '/../../bootstrap.php');

if (!empty($_POST['employeeId'])) {
    // Get all the employees of the current hub
    $users = User::getAllUsers();

    $employees = [];

    foreach ($users as $u) {
        if ($u['Id'] == $_POST['employeeId'] && $u['RoleName'] === 'Employee') {
            // Push Firstname, Lastname, and Taskname as an associative array to the employees array
            $employees[] = [
                'Taskname' => $u['Taskname'],
            ];
        }
    }

    // Return array of employees
    $response = [
        'status' => 'success',
        'body' => $employees,
        'message' => 'Employee task retrieved',
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'EmployeeId is missing',
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
