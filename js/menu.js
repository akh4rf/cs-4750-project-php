function toggle_visibility(id) {
  let e = document.getElementById(id);
  if (e !== null) {
    if (e.classList.contains("active")) {
      e.classList.remove("active");
    } else {
      e.classList.add("active");
    }
  }
}

const isDescendant = function (parent, child) {
  let node = child.parentNode;
  while (node) {
    if (node === parent) {
      return true;
    }

    // Traverse up to the parent
    node = node.parentNode;
  }

  // Go up until the root but couldn't find the `parent`
  return false;
};

let menu = document.getElementById("menu");
if (menu !== null) {
  document.addEventListener("click", (event) => {
    if (!isDescendant(document.getElementById("menu-wrapper"), event.target)) {
      menu.classList.remove("active");
    }
  });
}
