/**
 * Date: March 11 2025
 * Authors: Thomas De Sa, Patrick Bernacki, Abhishek Jariwala, Ojuoluwa Dabiri
 * 
 * Client Script for Search results page (search.php)
 */

onload = ()=>{
    if (search_input && search_input.trim() !== '') {
        const resultsText = document.createElement("span");
        document.getElementById("title").innerHTML = `${student_course_records.length} Results for "${search_input}"`;
        document.getElementById("left-arrow-container").hidden = false

    } else {
        document.getElementById("title").innerHTML = "Student Grades";
        document.getElementById("left-arrow-container").hidden = true
    }
    document.getElementById("left-arrow-svg").onclick = ()=>{window.location = '../index.php'}

    //Create a row for each course record
    for(let record of student_course_records) {
        let row = create_course_row(record);
        document.getElementById("search-results-container").appendChild(row);
    }

    //Setup searchbar
    document.getElementById("searchbar").value = search_input;
    document.getElementById("search-button").onclick = search;

    //Enter key presses search button
    document.getElementById("searchbar").addEventListener("keypress", (e)=>{
        if(e.key === "Enter"){
            document.getElementById("search-button").click();
        }
    });
    
    //close modify course when clicking off
    document.getElementById("blur").onclick = close_modify_course;
    document.getElementById("x-close").onclick = close_modify_course;
}

/**
 * Create a row for a single course record
 * @param {object} record - Contains StudentID, StudentName, CourseCode, FinalGrade, Grades
 * @return {HTMLDivElement} row - Div element to be added to doc tree
 */
function create_course_row(record) {
    let row = document.createElement("div");
    row.className = "student-card search-result border";
    
    // Student ID
    let idElement = document.createElement("h4");
    idElement.className = "card-content id";
    idElement.textContent = record.StudentID;
    
    // Student Name
    let nameElement = document.createElement("h4");
    nameElement.className = "card-content";
    nameElement.textContent = record.StudentName;
    
    // Course Code
    let courseElement = document.createElement("h4");
    courseElement.className = "card-content";
    courseElement.textContent = record.CourseCode;
    
    // Final Grade
    let gradeElement = document.createElement("h4");
    gradeElement.className = "card-content";
    gradeElement.textContent = `${parseFloat(record.FinalGrade).toFixed(1)}%`;
    
    // Add click handler to show modify popup
    row.onclick = () => {
        modify_course(record.Grades, record.StudentName, record.StudentID);
    };
    
    // Append all elements
    row.appendChild(idElement);
    row.appendChild(nameElement);
    row.appendChild(courseElement);
    row.appendChild(gradeElement);

    return row;
}

/**
 * Get value from search bar and go to search result page (search.php?search={})
 */
function search() {
    let search_input = document.getElementById("searchbar").value;
    window.location = `./search.php?search=${encodeURIComponent(search_input)}`;
}

/**
 * Create modify course popup when a row is clicked
 * @param {object} course_grades - Contains course grades (test1, test2, test3, finalExam)
 * @param {string} studentId - Student ID
 */
function modify_course(course_grades, student_name, studentId) {
    document.getElementById("modify-course").classList.add("modify-course");
    //set title to course code
    document.getElementById("popup-course-code").innerHTML =
      `${student_name} - ${course_grades.courseCode}`;

    document.getElementById("student-id-input").value = studentId;

  
    //iterate over course grades and create row for each test
    const test_names = [0, 0, "Test 1", "Test 2", "Test 3", "Final Exam"];
    keys = Object.keys(course_grades);
    for (let i = 2; i < keys.length; i++) {
      const h3 = document.createElement("h3")
      h3.className = "test-h3"
      h3.innerHTML = test_names[i]
      const h4 = document.createElement("h4")
      h4.innerHTML = `${Number(course_grades[keys[i]]).toFixed(1)}%`
      
      const input = document.createElement("input")
      input.type = "text"
  
      //Set input field id and name to its key (i.e., test1, test2...)
      input.id = keys[i]
      input.name = keys[i]
      
      input.oninput = (e)=>{validate_modify_form(e)}
  
      //set clear button
      document.getElementById("clear-grades").onclick = ()=>{clear_popup(course_grades)}
  
      //placeholders
      const ph = document.createElement("div")
      ph.className = "placeholder"
      const ph2 = document.createElement("div")
      ph2.className = "placeholder"
      const ph3 = document.createElement("div")
      ph3.className = "placeholder"
  
      const percent = document.createElement('h4')
      percent.innerHTML = "%"
  
      //Hidden input field to pass the course code to POST
      const hidden_field = document.createElement("input")
      hidden_field.type = "hidden"
      hidden_field.name = "course-code"
      hidden_field.value = course_grades.courseCode
  
      const div = document.createElement("div")
      div.className = "row"
      div.appendChild(ph)
      div.appendChild(h3)
      div.appendChild(h4)
      div.appendChild(ph3)
      div.appendChild(input)
      div.appendChild(percent)
      div.appendChild(ph2)
      div.appendChild(hidden_field)
  
      document.getElementById("popup-tests").appendChild(div)
    }
  
    //show the popup and blur effect
    document.getElementById("modify-course").hidden = false;
    document.getElementById("blur").hidden = false;
  }
  
  /**
   * Close modify course popup and destroy children
   */
  function close_modify_course() {
    document.getElementById("modify-course").classList.remove("modify-course");
  
    document.getElementById("modify-course").hidden = true;
    document.getElementById("blur").hidden = true;
  
    const div = document.getElementById("popup-tests")
    while(div.firstChild){
      div.removeChild(div.lastChild)
    }
  
  }
  
  /**
   * Validate the update course grade form input
   * Makes sure that input is only numbers between [0, 100]
   * @param {Event} e 
   */
  function validate_modify_form(e){
    
    e.target.value = e.target.value.trim()
  
    //if input is: not a number or not in range [0,100]
    if(isNaN(e.target.value) || Number(e.target.value) < 0 || Number(e.target.value) >100){
      //remove value that was just added
      e.target.value = e.target.value.replace(e.data, "")
    }
  }
  
  /**
   * Function for clear button on popup form
   * 
   * @param {object} course_code    - associative array of course grades
   *                                 keys: "courseCode", "test1", "test2", "test3", "finalExam"
   */
  function clear_popup(course_grades){
    keys = Object.keys(course_grades);
    //clear value of all inputs on form
    for (let i = 2; i < keys.length; i++) {
      document.getElementById(keys[i]).value = ""
    }
  }