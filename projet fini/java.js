// Sélectionner le carrousel et ses flèches
const carouselContainer = document.querySelector('.colonnestages .carousel-items');
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

let currentIndex = 0;
const totalItems = 5; // Nombre total de news

function Slide(index) {
    const carouselItems = document.querySelector('.carousel-items');
    const offset = -index * (50); // Décalage en pourcentage
    carouselItems.style.transform = `translateX(${offset}%)`;
}

function prochaineslide() {
    if (currentIndex < totalItems - 2) {
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

// Fonction pour ouvrir le pop-up
function openPopup() {
    const popup = document.getElementById('popup');
    popup.style.display = 'flex'; // Affiche le pop-up
}

// Fonction pour fermer le pop-up
function closePopup() {
    const popup = document.getElementById('popup');
    popup.style.display = 'none'; // Cache le pop-up
}

// Optionnel : Fermer le pop-up en cliquant à l'extérieur
window.addEventListener('click', (e) => {
    const popup = document.getElementById('popup');
    if (e.target === popup) {
        popup.style.display = 'none';
    }
});


function switchToLogin() {
    // Change the title
    document.getElementById('form-title').innerText = 'Connexion';

    // Hide name fields
    document.getElementById('name-fields').style.display = 'none';

    document.getElementById('info-fields').style.display = 'none';

    // Only keep email and password fields
    document.getElementById('password-fields').innerHTML = `
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required></input>
    `;

    // Optionally, you can change the "Envoyer" button text
    document.querySelector('.boutonpop[type="submit"]').innerText = 'Se connecter';

    // Change the toggle button to switch back to signup
    const toggleButton = document.getElementById('toggle-button');
    toggleButton.innerText = "S'inscrire";
    toggleButton.setAttribute('onclick', 'switchToSignup()');
}

function switchToSignup() {
    // Change the title
    document.getElementById('form-title').innerText = 'Formulaire d\'inscription';

    // Show name fields
    document.getElementById('name-fields').style.display = 'block';

    document.getElementById('info-fields').style.display = 'block';

    // Restore email and password fields to include verification
    document.getElementById('password-fields').innerHTML = `
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required></input>

        <label for="passwordverif">Vérification du Mot de passe :</label>
        <input type="password" id="passwordverif" name="passwordverif" required></input>
    `;

    // Optionally, you can change the "Envoyer" button text back to "Envoyer"
    document.querySelector('.boutonpop[type="submit"]').innerText = 'Envoyer';

    // Change the toggle button to switch back to login
    const toggleButton = document.getElementById('toggle-button');
    toggleButton.innerText = "Se connecter";
    toggleButton.setAttribute('onclick', 'switchToLogin()');
}