<!-- 
Date: March 19 2025
Authors: Thomas De Sa,

Page to display and modify student information (grades).

Page is accessed by clicking on the student card of a search result
from search.php -->
<!DOCTYPE html>

<?php
include("../scripts/db_functions.php"); 

$id = $_GET["id"];
$student_records = get_student_grades($id);

$json = json_encode($student_records); 
echo "<script>let student_records = $json</script>"; 

echo $id; 
?>