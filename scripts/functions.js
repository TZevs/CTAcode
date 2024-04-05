// Transaction Tabs
function openTransfers(evt, transferOptions) {
    var i, tabcontent, tablinks;

    // Hide tab content
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Removes active class from tab links
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab content, add the active class
    document.getElementById(transferOptions).style.display = "block";
    evt.currentTarget.className += " active";
}