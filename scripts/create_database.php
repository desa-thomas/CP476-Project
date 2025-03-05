<?php
/*
Date   - Feb 26 2024
Author - Thomas De Sa

Script to be ran on server start up or creation. It should only be ran once, or if you want 
to reset the database back to its original state.

Connects to mysql server using .env variables, creates the database and tables, then 
loads the data from the provided .txt files.
*/

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
            $conn->select_db($DB_name);
        } else {
            echo "Could not create $DB_name";
        }
    } else {
        echo "Error connecting: " . $e->getMessage();
    }
}

#drop tables
$conn->query("DROP TABLE IF EXISTS NameTable, CourseTable");

#Create tables NameTable, and CourseTable
$query =
    "CREATE TABLE NameTable 
(
    StudentID varchar(9) CHECK (CHAR_LENGTH(StudentID) = 9 AND StudentID REGEXP '^[0-9]+$'),
    StudentName varchar(50) NOT NULL,
    PRIMARY KEY(StudentID)
)";

$conn->query($query);

$query = "CREATE TABLE CourseTable(
    StudentID varchar(9),
    courseCode varchar(5) not null,
    test1 float not null,
    test2 float not null,
    test3 float not null,
    finalExam float not null,

    FOREIGN KEY (StudentID) REFERENCES NameTable(StudentID),
    
    CHECK (CHAR_LENGTH(courseCode) = 5 AND courseCode REGEXP '^[A-Z]{2}[0-9]{3}$'),

    constraint testscores CHECK(
        test1 between 0 and 100 and
        test2 between 0 and 100 and
        test3 between 0 and 100 and
        finalExam between 0 and 100
    ),

    constraint pk PRIMARY KEY (StudentID, courseCode)
)";

$conn->query($query);

echo "Tables Created...\n";

#Insert data into the tables using prepared statements
$stmt = $conn->prepare("INSERT INTO NameTable (StudentID, StudentName) VALUES (?, ?) ");
$stmt->bind_param("ss", $id, $name);

$file = fopen(__DIR__ . "/../proj data files/NameTable.txt", "r") or die("Unable to open file");
while (!feof($file)) {
    $line = fgets($file);

    #Not an empty line
    if ($line) {
        $id = substr($line, 0, 9);
        $name = substr($line, 11);
        $stmt->execute();
    }
}

$stmt = $conn->prepare("INSERT INTO CourseTable (StudentID, courseCode, test1, test2, test3, finalExam) VALUES (?, ?, ?, ?, ? , ?)");
$stmt->bind_param("ssdddd", $id, $coursecode, $t1, $t2, $t3, $fe); 

$file = fopen(__DIR__."/../proj data files/CourseTable.txt", "r");
while(!feof($file)){
    #split line on commas 
    $line = explode(",", fgets($file));

    if($line){
        #store references in arr so you can execute statment
        $arr = [&$id, &$coursecode, &$t1, &$t2, &$t3, &$fe];
        for($i = 0; $i< 6; $i++){
            $arr[$i] = trim($line[$i]);
        }
        $stmt->execute();    
    }
}

echo "Data loaded...\n";
echo "Closing connection.\n";
$conn->close();

?>