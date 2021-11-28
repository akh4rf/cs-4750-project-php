
//if clicking on button, open modal
document.getElementById("myButton").onclick = function() {
    document.getElementById("myModal").style.display = "flex";
}

//if clicking on x, close modal
document.getElementsByClassName("close")[0].onclick = function() {
    document.getElementById("myModal").style.display = "none";
}

//if clicking anywhere outside modal, close modal
window.onclick = function(event) {
    if(event.target == document.getElementById("myModal")){
        document.getElementById("myModal").style.display = "none";
    }
}
