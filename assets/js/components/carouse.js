export const Carousel = () => {
  document.addEventListener("DOMContentLoaded", () => {
    const carouselContent = document.querySelector(".carousel-content");
    const prevButton = document.querySelector(".carousel-previous");
    const nextButton = document.querySelector(".carousel-next");
    let currentIndex = 0;

    // Create carousel items
    for (let i = 0; i < 5; i++) {
      const item = document.createElement("div");
      item.className =
        "carousel-item pl-1 w-full md:w-1/2 lg:w-1/3 flex-shrink-0";
      item.innerHTML = `
            <div class="p-1">
                <div class="bg-white rounded-lg shadow">
                    <div class="flex aspect-square items-center justify-center p-6">
                        <span class="text-2xl font-semibold">${i + 1}</span>
                    </div>
                </div>
            </div>
        `;
      carouselContent.appendChild(item);
    }

    const items = document.querySelectorAll(".carousel-item");

    function updateCarousel() {
      const offset = currentIndex * -100;
      carouselContent.style.transform = `translateX(${offset}%)`;
    }

    prevButton.addEventListener("click", () => {
      if (currentIndex > 0) {
        currentIndex--;
        updateCarousel();
      }
    });

    nextButton.addEventListener("click", () => {
      if (currentIndex < items.length - 1) {
        currentIndex++;
        updateCarousel();
      }
    });

    // Initial update
    updateCarousel();
  });
};
