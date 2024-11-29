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
