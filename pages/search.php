<!-- 
Date: March 11 2025
Authors: Thomas De Sa, Patrick Bernacki, Abhishek Jariwala, Ojuoluwa Dabiri

Search for Student by ID in DB, then return HTML page displaying those results
-->
<!DOCTYPE html>

<?php
include("../scripts/db_functions.php");
include("../scripts/auth_check.php");
check_auth();

//Get search value from URL parameters
$search_input = $_GET["search"];
$search_results = search_students($search_input);

//Store the last search for redirects after modify
$_SESSION['last_search'] = $search_input;

//Get all course records for the search results
$student_course_records = [];
foreach ($search_results as $student) {
    $courses = get_student_grades($student["StudentID"]);
    foreach ($courses as $course) {
        //Calculate final grade for each course
        $final_grade = round($course['test1'] * 0.2 +
            $course['test2'] * 0.2 +
            $course['test3'] * 0.2 +
            $course['finalExam'] * 0.4, 1);
        $final_grade = round($final_grade * 100) / 100;

        $student_course_records[] = [
            'StudentID' => $student['StudentID'],
            'StudentName' => $student['StudentName'],
            'CourseCode' => $course['courseCode'],
            'FinalGrade' => $final_grade,
            'Grades' => $course // Include all grade details for popup
        ];
    }
}

//pass search results to javascript
echo "<script>
let student_course_records = " . json_encode($student_course_records) . ";
let search_input = '$search_input';
</script>";
?>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../frontend/styles.css">
    <script src="../frontend/searchresults.js"></script>
</head>

<body>
    <div class="content main">
        <div class="header">
            <div id ="left-arrow-container" hidden>
                <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" class="svg"
                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path id="left-arrow"
                        d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 288 480 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-370.7 0 73.4-73.4c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-128 128z" />
                </svg>
            </div>

            <h1 id="title">Search Results</h1>
            <div class="placeholder"></div>

            <div>
                <input id="searchbar" type="text" placeholder="Search by id/name">
                <button id="search-button">Search</button>
                <button onclick="window.location.href='../scripts/logout.php'">Logout</button>
            </div>
        </div>

        <hr>

        <div id="search-results-container">
            <div class="student-card student-card-header">
                <h2 class="card-content id">ID</h2>
                <h2 class="card-content">Name</h2>
                <h2 class="card-content">Course</h2>
                <h2 class="card-content">Final Grade</h2>
            </div>
        </div>

    </div>

    <!-- Modify course grades popup -->
    <div id="modify-course" hidden>
        <!-- Row with X -->
        <div class="row margin">
            <h2 id="popup-course-code">XX123</h2>

            <div class="placeholder"></div>
            <svg xmlns="http://www.w3.org/2000/svg" width="25px" height="25px"
                viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                <path id="x-close"
                    d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
            </svg>
        </div>
        <hr>

        <form action="../scripts/modify_course.php" method="POST" class="col" style="gap:20px">
            <div id="popup-tests" class="col">
                <!-- Test scores for popup form -->
            </div>

            <div id="popup-buttons" class="row">
                <div class="placeholder"></div>
                <button id="clear-grades" type="button">Clear</button>
                <button id="update-grades" type="submit" name="UPDATE">Update Grades</button>
                <button id="DELETE-COURSE" type="submit" name="DELETE">Delete Course</button>
                <div class="placeholder"></div>
            </div>

            <!-- Hidden input containing student Id -->
            <input type="hidden" name="id" id="student-id-input">
            <div class="placeholder"></div>
        </form>
    </div>
    <div id="blur" class="blur" hidden></div>
</body>