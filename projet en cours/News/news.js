let currentIndex = 0;
const totalItems = 5; // Nombre total de news

function Slide(index) {
    const carouselItems = document.querySelector('.carousel-items');
    const offset = -index * (50); // Décalage en pourcentage
    carouselItems.style.transform = `translateX(${offset}%)`;
}

function prochaineslide() {
    if (currentIndex < totalItems-2) {
        currentIndex++;
        Slide(currentIndex);
    }
}

function precedenteslide() {
    if (currentIndex > 0) {
        currentIndex--;
        Slide(currentIndex);
    }
}

// Initialisation
Slide(currentIndex);
