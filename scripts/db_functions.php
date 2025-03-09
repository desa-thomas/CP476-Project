<?php
/*
Date  : March 5 2025
Author: Thomas De Sa

Functions to query the CP476-Project Database.

I am assuming you cannot make changes to the NameTable Table 
i.e., You can't modify Students names or IDs
*/

$_ENV = parse_ini_file(__DIR__ . "/../.env");

/**
 * Delete a student's course record from database
 * 
 * @param string $id         9 digit Student ID
 * @param string $coursecode Course code of course to delete, format (cciii)
 * 
 * @return array(bool, string) $deleted - (true if deleted, message)
 */
function delete_course(string $id, string $coursecode){
    try{
        $conn = new mysqli($_ENV["SERVER"], $_ENV["USERNAME"], $_ENV["PASSWORD"], $_ENV["DB_NAME"]); 
    }catch(Exception $e){
        return [false, $e->getMessage()];
    }

    $stmt = $conn->prepare("DELETE FROM CourseTable WHERE (Studentid = ? and courseCode = ?)"); 
    $stmt->bind_param("ss", $id, $coursecode);
    $stmt->execute();

    /**Rows affected by DELETE statement */
    $affected_rows = $conn->affected_rows;
    $conn->close(); 

    if($affected_rows == 1){
        return[true, "Course Deleted"];
    }
    else{
        return[false, "Course or Student not found"];
    }
}

/**
 * Modify a student's grade for a particular test in a course
 * 
 * @param string $id         9 digit Student ID
 * @param string $coursecode Course code for the class for which grade to udpate (cciii)
 * @param array(float)  $new_vals  Associative array of updated values e.g., 
 *                           ["test1" => updated_value,
 *                            "test2" => updated value,
 *                            "test3" => updated value,
 *                            "finalExam" => updated value]    
 *                            Null values for entries that won't be udpated
 *      
 *                           1, 2, 3, for test1, test2, and test3 repectively & 4 for the final exam
 * 
 * @return array(bool, string) $modified  [column_modified, message]
 */
function modify_grades(string $id, string $coursecode, array $new_vals){
    $key_template = ["test1", "test2", "test3", "finalExam"]

    if(array_keys($new_vals) != $key_template){
        return [false, "Associative array keys should have format:\n". '["test1", "test2", "test3", "finalExam"]']
    }
    try{
        $conn = new mysqli($_ENV["SERVER"], $_ENV["USERNAME"], $_ENV["PASSWORD"], $_ENV["DB_NAME"]); 
    }catch(Exception $e){
        return [false, $e->getMessage()];
    }

    foreach($new_vals as $key=> $value){
            
    }
    return 
}

?>