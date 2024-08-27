<?php
include_once(__DIR__ . '/../../bootstrap.php');

if (!empty($_POST['LocationId'])) {
    // Get all the employees of the current hub
    $users = User::getAllUsers();

    $employees = [];

    foreach ($users as $u) {
        if ($u['LocationId'] == $_POST['LocationId'] && $u['RoleName'] === 'Employee') {
            // Push Firstname, Lastname, and Taskname as an associative array to the employees array
            $employees[] = [
                'Id' => $u['Id'],
                'Firstname' => $u['Firstname'],
                'Lastname' => $u['Lastname'],
                'Taskname' => $u['Taskname']
            ];
        }
    }

    // Return array of employees
    $response = [
        'status' => 'success',
        'body' => $employees,
        'message' => 'Employees retrieved',
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'LocationId is missing',
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
