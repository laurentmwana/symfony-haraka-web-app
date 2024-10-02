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
const menuToggle = document.getElementById("menuToggle");
const sidebarMenu = document.getElementById("sidebarMenu");
menuToggle.addEventListener("click", () => {
  sidebarMenu.classList.toggle("hidden");
  sidebarMenu.classList.toggle("block");
});
