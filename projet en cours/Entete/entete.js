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
        <textarea id="password" name="password" required></textarea>
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
        <textarea id="password" name="password" required></textarea>

        <label for="passwordverif">Vérification du Mot de passe :</label>
        <textarea id="passwordverif" name="passwordverif" required></textarea>
    `;

    // Optionally, you can change the "Envoyer" button text back to "Envoyer"
    document.querySelector('.boutonpop[type="submit"]').innerText = 'Envoyer';

    // Change the toggle button to switch back to login
    const toggleButton = document.getElementById('toggle-button');
    toggleButton.innerText = "se connecter";
    toggleButton.setAttribute('onclick', 'switchToLogin()');
}
