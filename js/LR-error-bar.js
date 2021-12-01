function dismissErrorBar() {
  document
    .getElementsByClassName("login-error-bar")[0]
    .classList.add("display-none");
}
let error_bar = document.getElementsByClassName("login-error-dismiss")[0];
if (error_bar !== null && error_bar !== undefined) {
  error_bar.addEventListener("click", dismissErrorBar);
}
