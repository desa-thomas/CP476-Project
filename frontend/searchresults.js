/**
 * Date: March 11 2025
 * Authors: Thomas De Sa,
 * 
 * Client Script for Search results page
 */

onload = ()=>{
    //search_results from search.php
    for(row of search_results){
        console.log(row)
        let studentcard = create_student_card(row.StudentID, row.StudentName)
        document.getElementById("search-results-container").appendChild(studentcard)
    }
}

/**
 * Create a student search result card based on student ID and name
 * @param {string} id   - 9 digit student ID 
 * @param {string} name - Student full name
 * 
 * @return {HTMLDivElement} studentcard - Div element to be added to doc tree
 */
function create_student_card(id, name){

    let studentcard = document.createElement("div")

    studentcard.className = "student-card"
    
    let idElement = document.createElement("h3")
    let nameElement = document.createElement("h3")

    idElement.innerHTML = id
    nameElement.innerHTML = name

    studentcard.appendChild(idElement)
    studentcard.appendChild(nameElement)

    return studentcard
}