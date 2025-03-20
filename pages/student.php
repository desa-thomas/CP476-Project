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
    <div class="content">
        <!-- header: ID - name     searchbar -->
        <div class="header">
            <h2 id="title">ID</h2>
            <div class="placeholder"></div>
            <div>
                <input id="searchbar" type="text" placeholder="Student Id or name">
                <button id="search-button">Search</button>
            </div>
        </div>
        <hr>

        <div id="search-results-container">


        </div>

    </div>
    </div>

</body>