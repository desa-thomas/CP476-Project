/**
 * Date: March 11 2025 
 * Authors: Thomas De Sa, 
 * 
 * Client script for the search page
 */
onload = ()=>{

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
 * Get value from search bar and go to searchresults page (search.php)
 * @returns 
 */
function search(){
    let search_input = document.getElementById("searchbar").value

    window.location = `/scripts/search.php?search=${search_input}`

    return
}