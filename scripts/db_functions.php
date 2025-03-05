<?php
/*
Date  : March 5 2025
Author: Thomas De Sa

Functions to query the CP476-Project Database.

I am assuming you cannot make changes to the NameTable Table 
i.e., You can't modify Students names or IDs
*/


/**
 * Delete a student's course record from database
 * 
 * @param string $id         9 digit Student ID
 * @param string $coursecode Course code of course to delete, format (cciii)
 */
function delete_course(string $id, string $coursecode){

}

/**
 * Modify a students grade for a particular test in a course
 * 
 * @param string $id         9 digit Student ID
 * @param string $coursecode Course code for the class for which grade to udpate (cciii)
 * @param int    $test_no    Test no of test which grade we want to update.
 *                           1, 2, 3, for test1, test2, and test3 repectively & 4 for the final exam
 * @param float  $new_grade  Value of the new grade
 */
function modify_grade(string $id, string $coursecode, int $test_no, float $new_grade){

    return
}
?>

