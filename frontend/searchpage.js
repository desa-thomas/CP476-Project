/**
 * Date: March 11 2025 
 * Authors: Thomas De Sa, 
 * 
 * Client script for the search page
 */
onload = ()=>{

    document.getElementById("searchbar").value = ""
    document.getElementById("search-button").onclick = validate_search

    //Enter key presses search button
    document.getElementById("searchbar").addEventListener("keypress", (e)=>{
        if(e.key === "Enter"){
            document.getElementById("search-button").click()
        }
    })
}

function validate_search(){
    let search_input = document.getElementById("searchbar").value

    /**TODO Validate search */

    console.log(`/scripts/search.php?search=${search_input}`)
    window.location = `/scripts/search.php?search=${search_input}`

    return
}