<?php
#Parse .env
$_ENV = parse_ini_file(__DIR__."/../.env");
$datafile_dir = __DIR__ . "/../proj data files";

#connect to DB using env variables
$DB_name = $_ENV["DB_NAME"];
try{
    $conn = new mysqli($_ENV["SERVER"], $_ENV["USERNAME"], $_ENV["PASSWORD"], $DB_name);
}
catch (Exception $e){
    #If database doesn't exist create it
    if($e->getMessage() == "Unknown database '" . strtolower($DB_name) ."'"){
        echo "make";
    }

    else{
        echo "Error connecting: " . $e->getMessage(); 
    }
}


$file = fopen($datafile_dir . "/CourseTable.txt", "r") or die("Unable to open file");

// while(!feof($file)){
    
// }
?>