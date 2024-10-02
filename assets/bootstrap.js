// Toggle Edifice Dropdown
const edificeDropdown = document.getElementById("edificeDropdown");
const edificeMenu = document.getElementById("edificeMenu");
edificeDropdown.addEventListener("click", () => {
  edificeMenu.classList.toggle("hidden");
});

// Toggle User Menu
const userMenuToggle = document.getElementById("userMenuToggle");
const userMenu = document.getElementById("userMenu");
userMenuToggle.addEventListener("click", () => {
  userMenu.classList.toggle("hidden");
});

// Toggle Responsive Menu
const menuToggle = document.getElementById("menuToggle");
const sidebarMenu = document.getElementById("sidebarMenu");
menuToggle.addEventListener("click", () => {
  sidebarMenu.classList.toggle("hidden");
  sidebarMenu.classList.toggle("block");
});

// Close dropdowns when clicking outside
document.addEventListener("click", (event) => {
  if (!edificeDropdown.contains(event.target)) {
    edificeMenu.classList.add("hidden");
  }
  if (!userMenuToggle.contains(event.target)) {
    userMenu.classList.add("hidden");
  }
});

const toggleTheme = () => {
  // On sélectionne l'élément HTML
  const htmlElement = document.documentElement;

  // Si la classe 'dark' est déjà présente, on la retire (mode light)
  // Sinon, on l'ajoute (mode dark)
  if (htmlElement.classList.contains("dark")) {
    htmlElement.classList.remove("dark");
    localStorage.setItem("theme", "light"); // Sauvegarder la préférence utilisateur
  } else {
    htmlElement.classList.add("dark");
    localStorage.setItem("theme", "dark"); // Sauvegarder la préférence utilisateur
  }
};

document.documentElement.classList.add("dark");

toggleTheme();

// Appliquer le thème sauvegardé lors du chargement de la page
window.onload = function () {
  const savedTheme = localStorage.getItem("theme");
  if (savedTheme === "dark") {
    document.documentElement.classList.add("dark");
  } else {
    document.documentElement.classList.remove("dark");
  }
};

document.querySelectorAll("#responsive-table").forEach((table) => {
  const labels = Array.from(table.querySelectorAll("th")).map(
    (th) => th.innerText
  );
  table.querySelectorAll("td").forEach((td, index) => {
    td.setAttribute("data-label", labels[index % labels.length]);
  });
});
