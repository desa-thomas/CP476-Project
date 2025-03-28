<?php
/*
Date  : March 5 2025
Authors: Thomas De Sa, Patrick Bernacki, Abhishek Jariwala, Ojuoluwa Dabiri

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
        return[true, "Course Deleted Successfully"];
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
 * @param array $new_vals  Associative array of updated values (array of floats or null) e.g., 
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
    $key_template = ["test1", "test2", "test3", "finalExam"];

    if(array_keys($new_vals) != $key_template){
        return [false, "Associative array keys should have format:\n". '["test1", "test2", "test3", "finalExam"]'];
    }
    try{
        $conn = new mysqli($_ENV["SERVER"], $_ENV["USERNAME"], $_ENV["PASSWORD"], $_ENV["DB_NAME"]); 
    }catch(Exception $e){
        return [false, $e->getMessage()];
    }

    $query = "UPDATE CourseTable SET "; 
    $values = [];
    $types = "";

    /**Iterate over values given, append all updated grades to a list */
    foreach($new_vals as $key=> $value){
        if($value != null){
            /** Update Query for every value changed, and keep track of values to be updated */
            $query.="$key = ?, ";
            array_push($values, $value); 
            $types .= "d"; 
        }
    }
    /** If no values are given to update return */
    if (count($values) == 0 ){
        return [false, ""]; 
    }

    /** Add WHERE clause to query */
    $query = substr($query, 0, -2); 
    $query .= " WHERE StudentID = ? AND courseCode = ?";
    array_push($values, $id, $coursecode);
    $types .= "ss"; 

    /** Create prepared statemetn */
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$values); 

    $stmt->execute();

    /**Rows affected by MODIFY statement */
    $affected_rows = $conn->affected_rows;
    $conn->close();

    if ($affected_rows){
        return [true, "Grades updated Successfully"]; 
    }
    else{
        return [false, "No rows affected ... Check student ID and Course"]; 
    }
}

/**
 * Performs a search query for id, returns array of matching ids
 * 
 * @param string $search_str - search input (id or nae)
 * @return array     - 2d array of results each element in array contains associative array with keys
 *                     ["StudentID"] and ["StudentName"]
 */
function search_students(string $search_str){

    try{
        $conn = new mysqli($_ENV["SERVER"], $_ENV["USERNAME"], $_ENV["PASSWORD"], $_ENV["DB_NAME"]); 
    }catch(Exception $e){
        echo $e->getMessage(); 
        return [];
    }

    $idQuery= '^'.$search_str;
    $nameQuery = "%".$search_str."%";

    /** Search DB for all Ids that match the start of the inputted id */
    $query = 'SELECT StudentID, StudentName FROM NameTable WHERE (StudentID REGEXP ? OR studentname LIKE ?)';
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $idQuery, $nameQuery);
    $stmt->execute();

    $ids = [];
    $result = $stmt->get_result(); 
    $conn->close();
    foreach($result as $row){
        array_push($ids, $row);
    }

    return $ids;
}

/**
 * Get the grades stored in coursetable for student with id
 * 
 * @param string $id      - Student's 9 digit id
 * @return array $courses - Return 2D array containing all course grades for studnet    
 *                          (every index contains an associative array of course grades)
 */
function get_student_grades(string $id){
    // Connect to db
    try{
        $conn = new mysqli($_ENV["SERVER"], $_ENV["USERNAME"], $_ENV["PASSWORD"], $_ENV["DB_NAME"]); 
    }catch(Exception $e){
        echo $e->getMessage(); 
        return [];
    }

    //prepare and execute query
    $query = "SELECT * FROM CourseTable WHERE StudentID = ?"; 
    $stmt = $conn->prepare($query); 
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result(); 
    $conn->close();

    $courses = [];
    //Each row is a course that student is taking, append it to courses array
    foreach($result as $row){
        array_push($courses, $row); 
    }
    
    return $courses ;
}


/**
 * 
 * @param string $id      - id of student whose courses to search for
 * @return array $courses - array of course codes of courses student is taking
 */
function get_student_courses(string $id){
    
    if (strlen($id) != 9){
        echo "ID must be 9 digits long"; 
        return [];
    }

    // Connect to db
    try{
        $conn = new mysqli($_ENV["SERVER"], $_ENV["USERNAME"], $_ENV["PASSWORD"], $_ENV["DB_NAME"]); 
    }catch(Exception $e){
        echo $e->getMessage(); 
        return [];
    }

    //Prepare and execute query
    $query =  "SELECT courseCode from CourseTable WHERE studentId = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id); 
    $stmt->execute();
    $result = $stmt->get_result(); 
    $conn->close();

    $courses = []; 
    foreach($result as $row){
        array_push($courses, $row["courseCode"]); 
    }

    return $courses;
}
?>