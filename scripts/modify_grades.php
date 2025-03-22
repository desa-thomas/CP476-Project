<?php
/*
Date: March 18 2025
Authors: Thomas De Sa, 

Handle grade modification requests
*/

include("db_functions.php");
include("auth_check.php");
check_auth();

header('Content-Type: application/json');

// Get POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!isset($data['id']) || !isset($data['courseCode']) || !isset($data['grades'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters'
    ]);
    exit();
}

$result = modify_grades($data['id'], $data['courseCode'], $data['grades']);

echo json_encode([
    'success' => $result[0],
    'message' => $result[1]
]);
?> 