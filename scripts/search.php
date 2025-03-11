<!-- 
Date: March 11 2025
Authors: Thomas De Sa,

Search for Student by ID in DB, then return HTML page displaying those results
-->
<!DOCTYPE html>

<?php include("db_functions.php");

//Get search value from URL parameters
$id = $_GET["id"];
$ids = search_id($id);

//pass search results to javascript for dynamic loading of content
$json = json_encode($ids);
echo "<script>let search_results = $json</script>";
?>



<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../frontend/styles.css">
    <script src="../frontend/searchresults.js"></script>
</head>