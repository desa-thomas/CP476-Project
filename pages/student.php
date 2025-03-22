<!-- 
Date: March 19 2025
Authors: Thomas De Sa,

Page to display and modify student information (grades).

Page is accessed by clicking on the student card of a search result
from search.php -->
<!DOCTYPE html>

<!-- Include the script tags to the head -->

<head>
    <?php
    include("../scripts/db_functions.php");
    include("../scripts/auth_check.php");
    check_auth();

    $id = $_GET["id"];
    //get student records and name
    $student_records = get_student_grades($id);
    $name = trim(search_students($id)[0]["StudentName"]);

    $json = json_encode($student_records);

    //pass the student records and name to the javascript
    echo "<script>
    let student_records = $json;
    let id = $id; 
    let studentName = '$name';</script>";
    ?>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../frontend/styles.css">
    <script src="../frontend/studentRecords.js"></script>
</head>

<body>
    <div class="content main">
        <!-- header: ID - name     searchbar -->
        <div class="header">
            <h2 id="title" class="click">ID</h2>
            <div class="placeholder"></div>
            <div class="search-group">
                <input id="searchbar" type="text" placeholder="Student Id or name">
                <button id="search-button">Search</button>
                <button onclick="window.location.href='../scripts/logout.php'">Logout</button>
            </div>
        </div>
        <hr>

        <div id="search-results-container">
        </div>
    </div>


</body>

<!-- Modify course grades popup -->
<div id="modify-course" hidden>
    <!-- Row with X -->
    <div class="row margin">
        <h2>XX123</h2>

        <div class="placeholder"></div>
        <svg xmlns="http://www.w3.org/2000/svg" width="25px" height="25px"
            viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
            <path id="x-close"
                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
        </svg>
    </div>

    <hr>

    <div class="col">
        <div class="row">
            <h3>Test 1:</h3>
            <h4>89%</h4>
            <div class="placeholder"></div>
            <h4>New value</h4>
            <input type="text">
        </div>

        <div class="row">
            <div class="placeholder"></div>
            <button>Clear</button>
            <button type="submit">Update Grades</button>
            <button id="DELETE-COURSE">Delete Course</button>
            <div class="placeholder"></div>
        </div>
    </div>
    
    <div class="placeholder"></div>

</div>
<div id="blur" class="blur" hidden></div>