function openTab(evt,tabname){
    var x, i, tabcontent, tablinks, tabcontentmain;

    tabcontent = document.getElementsByClassName("tabcontent");

    tablinks = document.getElementsByClassName("tablinks");
    for(i = 0; i < tabcontent.length; i++){
         tabcontent[i].style.display = "none";
    }
    
    for (i = 0; i < tablinks.length; i++){
        tablinks[i].classList.remove("active");
    }

    document.getElementById(tabname).style.display = "block";
    evt.classList.add("active");

    document.getElementById(tabname).scrollIntoView({
        behavior: 'smooth'
    });
}