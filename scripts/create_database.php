<?php
#Parse .env
$_ENV = parse_ini_file(__DIR__ . "/../.env");
$datafile_dir = __DIR__ . "/../proj data files";

#connect to DB using env variables
$DB_name = $_ENV["DB_NAME"];
try {
    $conn = new mysqli($_ENV["SERVER"], $_ENV["USERNAME"], $_ENV["PASSWORD"], $DB_name);
} catch (Exception $e) {

    #If database doesn't exist create it
    if ($e->getMessage() == "Unknown database '" . strtolower($DB_name) . "'") {
        $conn = new mysqli($_ENV["SERVER"], $_ENV["USERNAME"], $_ENV["PASSWORD"]);
        $query = "CREATE DATABASE $DB_name"; 

        if ($conn->query($query) == true) {
            echo "created $DB_name";
        }
        else{
            echo "Could not create $DB_name"; 
        }

        $conn->select_db($DB_name);
    } else {
        echo "Error connecting: " . $e->getMessage();
    }
}

#drop tables
$conn->query("DROP TABLE IF EXISTS NameTable, CourseTable");

#Create tables
?>