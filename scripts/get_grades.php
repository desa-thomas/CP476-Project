<?php
/*
Date: March 18 2025
Authors: Thomas De Sa, 

Get grades for a student and return as JSON
*/

include("db_functions.php");

header('Content-Type: application/json');

if (!isset($_GET["id"])) {
    echo json_encode(["error" => "No student ID provided"]);
    exit();
}

$student_id = $_GET["id"];
$grades = get_student_grades($student_id);

echo json_encode($grades);
?> 