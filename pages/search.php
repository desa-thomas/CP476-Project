<!-- 
Date: March 11 2025
Authors: Thomas De Sa,

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

//pass search results to javascript for dynamic loading of content
$json = json_encode($search_results);
echo "<script>let search_results = $json;
let search_input = '$search_input';</script>";
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
                <button onclick="window.location.href='../scripts/logout.php'" style="width: 100px;">Logout</button>
            </div>
        </div>

        <hr>

        <div id="search-results-container">
            <div class="student-card student-card-header">
                <h2 class="card-content">ID</h2>
                <h2 class="card-content">Name</h2>
            </div>
        </div>

    </div>

    <hr>
    <div class="content">
        <p>CP476 2025</p>
    </div>
</body>