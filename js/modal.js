let displayModal = () => {
  document.getElementById("myModal").style.display = "flex";
  document.getElementById("sidebar").style.zIndex = 5;
};

let closeModal = () => {
    document.getElementById("myModal").style.display = "none";
    document.getElementById("sidebar").style.zIndex = 10;
}

//if clicking on button, open modal
document.getElementById("myButton").onclick = function () {
  displayModal();
};

//if clicking on x, close modal
document.getElementsByClassName("close")[0].onclick = function () {
  closeModal();
};

//if clicking anywhere outside modal, close modal
window.onclick = function (event) {
  if (event.target == document.getElementById("myModal")) {
    closeModal();
  }
};
