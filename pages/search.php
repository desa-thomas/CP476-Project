<!-- 
Date: March 11 2025
Authors: Thomas De Sa,

Search for Student by ID in DB, then return HTML page displaying those results
-->
<!DOCTYPE html>

<?php include("../scripts/db_functions.php");

//Get search value from URL parameters
$search_input = $_GET["search"];
$search_results = search_students($search_input);

//Get the course codes for all student results
$student_courses = [];
foreach($search_results as $row){
    $courses = get_student_courses($row["StudentID"]);
    array_push($student_courses, $courses);
}

//pass search results to javascript for dynamic loading of content
$json = json_encode($search_results);
$student_courses_json = json_encode($student_courses); 

echo "<script>
let search_results = $json;
let search_input = '$search_input';
let courses = $student_courses_json;</script>";
?>



<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../frontend/styles.css">
    <script src="../frontend/searchresults.js"></script>
</head>

<body>
    <div class="content main">
        <div class="header">
            <h1 id="title" class="click">Search Results</h1>
            <div class="placeholder"></div>

            <div>
                <input id="searchbar" type="text" placeholder="Student Id or name">
                <button id="search-button">Search</button>
            </div>
        </div>

        <hr>

        <div id="search-results-container">
            <div class="student-card student-card-header">
                <h2 class="card-content id">ID</h2>
                <h2 class="card-content">Name</h2>
                <h2 class="card-content">Courses</h2>
            </div>
        </div>

    </div>
</body>