/**
 * Date: March 11 2025
 * Authors: Thomas De Sa,
 * 
 * Client Script for Search results page (search.php)
 */

onload = ()=>{
    
    document.getElementById("title").innerHTML = `${search_results.length} Search Results for "${search_input}"`
    document.getElementById("title").onclick = ()=>{window.location = '../index.html'}

    //search_results from search.php
    for(row of search_results){
        
        let studentcard = create_student_card(row.StudentID, row.StudentName)
        document.getElementById("search-results-container").appendChild(studentcard)
    }

    //Setup searchbar
    document.getElementById("searchbar").value = ""
    document.getElementById("search-button").onclick = search

    //Enter key presses search button
    document.getElementById("searchbar").addEventListener("keypress", (e)=>{
        if(e.key === "Enter"){
            document.getElementById("search-button").click()
        }
    })
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
    
    let idElement = document.createElement("h4")
    let nameElement = document.createElement("h4")

    idElement.innerHTML = id
    idElement.className = "card-content"

    nameElement.innerHTML = name
    nameElement.className = "card-content"

    //for hover and click
    studentcard.classList.add("search-result")
    studentcard.classList.add("border")
    studentcard.onclick = ()=>{get_student(id)}

    studentcard.appendChild(idElement)
    studentcard.appendChild(nameElement)

    return studentcard
}

/**
 * Get value from search bar and go to search result page (search.php?search={})
 * @returns 
 */
function search(){
    let search_input = document.getElementById("searchbar").value

    window.location = `/pages/search.php?search=${search_input}`

    return
}

/**
 * On click function for student search results card. Takes you to view student pages
 * 
 * @param id - Student Id to get
 */
function get_student(id){
    window.location = `/pages/student.php?id=${id}` 
    return 
}