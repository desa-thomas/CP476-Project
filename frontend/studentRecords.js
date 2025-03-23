/**
 * Date: March 19 2025
 * Authors: Thomas De Sa,
 *
 * Client script for the student records page (student.php)
 */

/**
 * On load script
 */
onload = () => {
  //set title
  document.getElementById("title").innerHTML = `${studentName} - ${id}`;
  document.getElementById("title").onclick = () => {
    window.location = "../index.php";
  };

  //create course card for each course student completed
  for (row of student_records) {
    let course_card = create_grade_card(row);
    document
      .getElementById("search-results-container")
      .appendChild(course_card);
  }

  //close modify course when clicking off
  document.getElementById("blur").onclick = close_modify_course;
  document.getElementById("x-close").onclick = close_modify_course;

  //Setup searchbar
  document.getElementById("searchbar").value = "";
  document.getElementById("search-button").onclick = search;

  //Enter key presses search button
  document.getElementById("searchbar").addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
      document.getElementById("search-button").click();
    }
  });
};

//FUNCTIONS

/**
 * Get value from search bar and go to search result page (search.php?search={})
 * @returns
 */
function search() {
  let search_input = document.getElementById("searchbar").value;

  window.location = `./search.php?search=${search_input}`;

  return;
}

/**
 * Create div contianing the test grades for a given class
 *
 * @param {object} course_grades - associative array of course grades
 *                                 keys: "courseCode", "test1", "test2", "test3", "finalExam"
 *
 * @return {HTMLDivElement}      - Div grade card containing all grades for course
 */
function create_grade_card(course_grades) {
  const top_div = document.createElement("div");

  //calculate final grade
  final_grade =
    course_grades.test1 * 0.2 +
    course_grades.test2 * 0.2 +
    course_grades.test3 * 0.2 +
    course_grades.finalExam * 0.4;
  final_grade = Math.round(final_grade * 100) / 100;

  //create course title card
  const course_title = document.createElement("div");
  course_title.className = "student-card student-card-header course";
  const title = document.createElement("h3");
  title.className = "card-content";
  title.innerHTML = course_grades.courseCode;

  final_grade_card = document.createElement("h3");
  final_grade_card.className = "card-content";
  final_grade_card.innerHTML = `Final Grade - ${final_grade}%`;

  course_title.appendChild(title);
  course_title.appendChild(final_grade_card);

  top_div.appendChild(course_title);

  //iterate over course grades and create cards for them
  let test_names = [0, 0, "Test 1", "Test 2", "Test 3", "Final Exam"];
  keys = Object.keys(course_grades);
  for (let i = 2; i < keys.length; i++) {
    const test_card = document.createElement("div");
    test_card.className = "student-card course-grade border";

    const test = document.createElement("h3");
    test.className = "card-content";
    const score = document.createElement("h3");
    score.className = "card-content";

    test.innerHTML = test_names[i];

    score.innerHTML = course_grades[keys[i]] + "%";

    test_card.appendChild(test);
    test_card.appendChild(score);

    //append to top level card
    top_div.appendChild(test_card);
  }

  //clicking course title toggles modify course
  course_title.onclick = () => {
    modify_course(course_grades);
  };

  //return card containing class grades
  return top_div;
}

/**
 * Create modify course popup when a course is clicked
 *
 * @param {object} course_code    - associative array of course grades
 *                                 keys: "courseCode", "test1", "test2", "test3", "finalExam"
 */
function modify_course(course_grades) {
  document.getElementById("modify-course").classList.add("modify-course");
  //set title to course code
  document.getElementById("popup-course-code").innerHTML =
    `Modify Course - ${course_grades.courseCode}`;

  //iterate over course grades and create row for each test
  const test_names = [0, 0, "Test 1", "Test 2", "Test 3", "Final Exam"];
  keys = Object.keys(course_grades);
  for (let i = 2; i < keys.length; i++) {
    const h3 = document.createElement("h3")
    h3.className = "test-h3"
    h3.innerHTML = test_names[i]
    const h4 = document.createElement("h4")
    h4.innerHTML = `${course_grades[keys[i]]}%`

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
