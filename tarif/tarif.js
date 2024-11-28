// Sélectionner le carrousel et ses flèches
const carouselContainer = document.querySelector('.stages .carousel-items');
const leftArrow = document.querySelector('.carousel-arrow.left');
const rightArrow = document.querySelector('.carousel-arrow.right');

if (carouselContainer) {
    let currentIndex = 0;

    function updateCarousel() {
        const totalItems = carouselContainer.children.length;
        const offset = -currentIndex * 100;
        carouselContainer.style.transform = `translateX(${offset}%)`;
    }

    function showNextSlide() {
        const totalItems = carouselContainer.children.length;
        currentIndex = (currentIndex + 1) % totalItems;
        updateCarousel();
    }

    function showPreviousSlide() {
        const totalItems = carouselContainer.children.length;
        currentIndex = (currentIndex - 1 + totalItems) % totalItems;
        updateCarousel();
    }

    // Naviguer avec les flèches
    rightArrow.addEventListener('click', showNextSlide);
    leftArrow.addEventListener('click', showPreviousSlide);
}
