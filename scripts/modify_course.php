<?PHP
include("../scripts/db_functions.php");
session_start(); 

$id = $_POST["id"]; 
$search_input = isset($_SESSION['last_search']) ? $_SESSION['last_search'] : '';

//If update grades button was clicked
if (isset($_POST["UPDATE"])) {
    $keys = ["test1", "test2", "test3", "finalExam"];
    $new_vals = [];

    //Create new_vals arr for modify_grades function
    foreach ($keys as $key) {
        //Empty strings => no update
        if ($_POST[$key] === "") {
            $_POST[$key] = null;
        }
        $new_vals[$key] = $_POST[$key];
    }

    $out = modify_grades($_POST["id"], $_POST["course-code"], $new_vals);
    
    //set session variable to function message
    $_SESSION["modify-message"] = $out[1]; 
    header("location: ../pages/search.php?search=$search_input"); 
}

//If delete button was clicked
else if (isset($_POST["DELETE"])) {
    //delete course
    $out = delete_course($id, $_POST["course-code"]);
    $_SESSION["modify-message"] = $out[1]; 
    header("location: ../pages/search.php?search=$search_input"); 
} 

else {
    echo "ERROR: UPDATE or DELETE was not specified";
}

exit(); 
?>