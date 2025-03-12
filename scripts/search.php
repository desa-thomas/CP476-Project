<!-- 
Date: March 11 2025
Authors: Thomas De Sa,

Search for Student by ID in DB, then return HTML page displaying those results
-->
<!DOCTYPE html>

<?php include("db_functions.php");

//Get search value from URL parameters
$search_input = $_GET["search"];
$search_results = search_students($search_input);

//pass search results to javascript for dynamic loading of content
$json = json_encode($search_results);
echo "<script>let search_results = $json</script>";
?>



<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../frontend/styles.css">
    <script src="../frontend/searchresults.js"></script>
</head>

<body>
    <div class="header">
        <h1>Search Results</h1>
    </div>

    <div id="search-results-container">
        <div class="student-card">
            <h3 class="student-id">123456789</h3>
            <h3 class="student-name">Name</h3>
        </div>
    </div>

</body>