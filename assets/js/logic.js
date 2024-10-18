document.querySelectorAll("#dropdown-menu").forEach((dropdownMenu) => {
  const dropdownTrigger = dropdownMenu.querySelector("#dropdown-trigger");
  const dropdownContent = dropdownMenu.querySelector("#dropdown-content");
  if (dropdownTrigger && dropdownContent) {
    dropdownTrigger.addEventListener("click", () =>
      dropdownContent.classList.toggle("hidden")
    );
  }

  document.addEventListener("click", (e) => {
    if (!dropdownMenu.contains(e.target)) {
      dropdownContent.classList.add("hidden");
    }
  });
});

// Toggle Responsive Menu
const menuToggle = document.getElementById("menu-toggle-button");
const sidebarMenu = document.getElementById("sidebarMenu");
if (sidebarMenu && menuToggle) {
  menuToggle.addEventListener("click", () => {
    sidebarMenu.classList.toggle("hidden");
    sidebarMenu.classList.toggle("block");
  });
}

document.querySelectorAll("#responsive-table").forEach((table) => {
  const labels = Array.from(table.querySelectorAll("th")).map(
    (th) => th.innerText
  );
  table.querySelectorAll("td").forEach((td, index) => {
    td.setAttribute("data-label", labels[index % labels.length]);
  });
});
