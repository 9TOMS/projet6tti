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







function inscriptionenfant() {
    // Change the title
    document.getElementById('form-title').innerText = 'Formulaire d\'inscription de l\'enfant';

    // Show name fields

    document.getElementById('info-kids-fields').style.display = 'grid';

    document.getElementById('info-parents-fields').style.display = 'grid' ;

    document.getElementById('info-person-fields').style.display = 'none' ;

    document.getElementById('info-kids-fields').innerHTML= `
                    <div>
                        <label for="name">Nom de l'enfant :</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div>
                        <label for="surname">Prénom de l'enfant :</label>
                        <input type="text" id="surname" name="surname" required>
                    </div>
                        

                    <div>
                        <label for="Age">Date de naissance de l'enfant :</label>
                        <input type="date" id="Age" name="Age" required>    
                    </div>
                     
                    <div>
                        <label for="sexe">sexe de l'enfant :</label>
                        <input type="text" id="sexe" name="sexe" maxlength="1" required>  
                    </div>
`;

    document.getElementById('info-parents-fields').innerHTML = `<div>
    <label for="parentname">Nom du parent :</label>
<input type="text" id="parentname" name="parentname" required>
</div>

<div>
    <label for="parentsurname">Prénom du parent :</label>
    <input type="text" id="parentsurname" name="parentsurname" required>
</div>


<div>
    <label for="phone">Numéro de téléphone :</label>
    <input type="tel" id="phone" name="phone" required>  
</div>

<div>
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required> 
</div>`;

    document.getElementById('info-fields').innerHTML = `<label for="entenduparler">Comment avez-vous entendu parler de nous ? :</label>
    <input type="text" id="entenduparler" name="entenduparler" required>

    <label for="Condition">Condition médicale (vaccin, groupe sanguin, asthme, allergies, ...) :</label>
    <input type="text" id="Condition" name="Condition" required>`;

    document.getElementById('password-fields').style.display = ' grid' ;

    // Restore email and password fields to include verification
    document.getElementById('password-fields').innerHTML = `
    <div>
        <label for="password">Mot de passe :</label>
        <input id="password" name="password" required> 
    </div>

    <div>
        <label for="passwordverif">Vérification du Mot de passe :</label>
        <input id="passwordverif" name="passwordverif" required> 
    </div>
    `;

    var boutonpop1 = document.getElementById('toggle-button-1');
    boutonpop1.setAttribute('onclick', '');
    boutonpop1.setAttribute('name', 'togglebutton1');

    var boutonpop2 = document.getElementById('toggle-button-2');
    boutonpop2.setAttribute('onclick', 'inscription()');
    boutonpop2.setAttribute('name', '');

    var boutonpop3 = document.getElementById('toggle-button-3');
    boutonpop3.setAttribute('onclick', 'connexion()');
    boutonpop3.setAttribute('name', '');
    
}


function inscription() {
    // Change the title
    document.getElementById('form-title').innerText = 'Formulaire d\'inscription de l\'enfant';

    // Show name fields
    document.getElementById('info-kids-fields').style.display = 'none';
    document.getElementById('info-parents-fields').style.display = 'none';

    document.getElementById('info-person-fields').style.display = 'grid';

    document.getElementById('info-person-fields').innerHTML = `<div>
    <label for="name">Nom :</label>
<input type="text" id="name" name="name" required>
</div>

<div>
    <label for="surname">Prénom :</label>
    <input type="text" id="surname" name="surname" required>
</div>

<div>
                        <label for="Age">Date de naissance de l'enfant :</label>
                        <input type="date" id="Age" name="Age" required>    
                    </div>
                     
                    <div>
                        <label for="sexe">sexe de l'enfant :</label>
                        <input type="text" id="sexe" name="sexe" maxlength="1" required>  
                    </div>


<div>
    <label for="phone">Numéro de téléphone :</label>
    <input type="tel" id="phone" name="phone" required>  
</div>

<div>
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required> 
</div>`;

    document.getElementById('info-fields').innerHTML = `

    
    <label for="entenduparler">Comment avez-vous entendu parler de nous ? :</label>
    <input type="text" id="entenduparler" name="entenduparler" required>

    <label for="Condition">Condition médicale (vaccin, groupe sanguin, asthme, allergies, ...) :</label>
    <input type="text" id="Condition" name="Condition" required>`;

    document.getElementById('password-fields').style.display = ' grid' ;

    // Restore email and password fields to include verification
    document.getElementById('password-fields').innerHTML = `
    <div>
        <label for="password">Mot de passe :</label>
        <input id="password" name="password" required> 
    </div>

    <div>
        <label for="passwordverif">Vérification du Mot de passe :</label>
        <input id="passwordverif" name="passwordverif" required> 
    </div>
    `;

    


    // Change the toggle button to switch back to login

    

    var boutonpop2 = document.getElementById('toggle-button-2');
    boutonpop2.setAttribute('onclick', '');
    boutonpop2.setAttribute('name', 'togglebutton2');


    var boutonpop1 = document.getElementById('toggle-button-1');
    boutonpop1.setAttribute('onclick', 'inscriptionenfant()');
    boutonpop1.setAttribute('name', '');

    var boutonpop3 = document.getElementById('toggle-button-3');
    boutonpop3.setAttribute('onclick', 'connexion()');
    boutonpop3.setAttribute('name', '');

    
}

function connexion() {
    // Change the title
    document.getElementById('form-title').innerText = 'Formulaire d\'inscription de l\'enfant';

    // Show name fields
    document.getElementById('info-kids-fields').style.display = 'none';

    document.getElementById('info-parents-fields').style.display = 'none' ;

    document.getElementById('info-person-fields').style.display = 'none' ;

    document.getElementById('info-fields').innerHTML = `<label for="email">Email :</label>
    <input type="email" id="email" name="email" required>  `;
    
    
    document.getElementById('password-fields').style.display = ' block' ;
    

    // Restore email and password fields to include verification
    document.getElementById('password-fields').innerHTML = `
    
        <label for="password">Mot de passe :</label>
        <input id="password" name="password" required> 
    `;

    

    


    // Change the toggle button to switch back to login
    

    var boutonpop1 = document.getElementById('toggle-button-1');
    boutonpop1.setAttribute('onclick', 'inscriptionenfant()');
    boutonpop1.setAttribute('name', '');

    var boutonpop2 = document.getElementById('toggle-button-2');
    boutonpop2.setAttribute('onclick', 'inscription()');
    boutonpop2.setAttribute('name', '');

    var boutonpop3 = document.getElementById('toggle-button-3');
    boutonpop3.setAttribute('onclick', '');
    boutonpop3.setAttribute('name', 'togglebutton3');
}





