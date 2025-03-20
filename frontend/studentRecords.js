/**
 * Date: March 19 2025
 * Author: Thomas De Sa
 *
 * Client script for the student records page (student.php)
 */
onload = () => {
  
    
  document.getElementById("title").innerHTML = `${id} - ${studentName}`;
  
  for (row of student_records){
    let course_card = create_grade_card(row)

    document.getElementById("search-results-container").appendChild(course_card)
  }

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

/**
 * Get value from search bar and go to search result page (search.php?search={})
 * @returns
 */
function search() {
  let search_input = document.getElementById("searchbar").value;

  window.location = `/pages/search.php?search=${search_input}`;

  return;
}

/**
 * @param {object} course_grades - associative array of course grades
 *                                 keys: "courseCode", "test1", "test2", "test3", "finalExam"
 * 
 * @return {HTMLDivElement}      - Div grade card containing all grades for course
 */
function create_grade_card(course_grades){
    
    let top_div = document.createElement("div")

    //create course title card
    let course_title = document.createElement("div")
    course_title.className = "student-card student-card-header"
    let title = document.createElement("h3")
    title.className = "card-content"
    title.innerHTML = course_grades.courseCode
    course_title.appendChild(title)

    top_div.appendChild(course_title)

    let test_names = [0, 0, "Test 1", "Test 2", "Test 3", "Final Exam"]
    //iterate over course grades and create cards for them
    keys = Object.keys(course_grades)
    for (let i = 2; i < keys.length; i ++){
        console.log(course_grades[keys[i]])
        let test_card = document.createElement("div")
        test_card.className = "student-card course-grade border"

        let test = document.createElement("h3")
        test.className = "card-content"
        let score = document.createElement("h3")
        score.className = "card-content"

        test.innerHTML = test_names[i]

        score.innerHTML = course_grades[keys[i]] + "%"

        test_card.appendChild(test)
        test_card.appendChild(score)

        //append to top level card
        top_div.appendChild(test_card)
    }

    return top_div
}
