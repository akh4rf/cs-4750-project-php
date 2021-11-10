function dismissErrorBar() {
  document
    .getElementsByClassName("login-error-bar")[0]
    .classList.add("display-none");
}
document.getElementsByClassName("login-error-dismiss")[0].addEventListener("click", dismissErrorBar);
