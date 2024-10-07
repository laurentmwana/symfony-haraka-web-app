export class ThemeToggleSwitch {
  constructor() {
    this.theme = "light";
    this.container = document.getElementById("theme-toggle-container");
    this.render();
    this.addEventListeners();
  }

  render() {
    this.container.innerHTML = `
      <div class="flex items-center space-x-2">
        <button id="theme-toggle" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 ${
          this.theme === "dark" ? "bg-indigo-600" : "bg-gray-200"
        }" role="switch" aria-checked="${this.theme === "dark"}">
          <span class="sr-only">Toggle theme</span>
          <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out ${
            this.theme === "dark" ? "translate-x-5" : "translate-x-0"
          }"></span>
        </button>
        <label for="theme-toggle" class="flex items-center space-x-2 cursor-pointer text-sm font-medium text-gray-900 dark:text-gray-100">
          <span class="w-5 h-5">${
            this.theme === "dark" ? this.moonIcon() : this.sunIcon()
          }</span>
          <span>${this.theme === "dark" ? "Sombre" : "Lumière"}</span>
        </label>
      </div>
    `;
  }

  addEventListeners() {
    const toggle = document.getElementById("theme-toggle");
    toggle.addEventListener("click", () => this.toggleTheme());
  }

  toggleTheme() {
    this.theme = this.theme === "light" ? "dark" : "light";
    document.documentElement.classList.toggle("dark");
    this.render();
  }

  sunIcon() {
    return `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>`;
  }

  moonIcon() {
    return `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
    </svg>`;
  }
}
