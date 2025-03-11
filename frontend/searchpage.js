/**
 * Date: March 11 2025 
 * Authors: Thomas De Sa, 
 * 
 * Client script for the search page
 */
onload = ()=>{

    console.log("loaded")
    document.getElementById("search-button").onclick = validate_search
}

function validate_search(){
    let id = document.getElementById("searchbar").value

    /**TODO Validate search */

    console.log(`/scripts/search.php?id=${id}`)
    window.location = `/scripts/search.php?id=${id}`

    return
}