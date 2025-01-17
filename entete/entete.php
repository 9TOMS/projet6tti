<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="entete.css" rel="stylesheet">
    <script src="entete.js"></script>
</head>
<body>
<div id ="tete">
    <div id ="logo">
        <img id ="logo1" src="images/logo.png">
    </div>
    <div id = "centre">
        <div id = "nom">
            <h1>Crépuscule</h1>
        </div>
         <div id = "citation">
            <h2>
            <span class="survole">Respect,
                    <span class="moment-survole">Respect des autres membres du club, des moniteurs et responsables, des consignes, du matériel et des infrastructures mais aussi et surtout des chevaux.</span>
                </span>
                <span class="survole">Confiance,
                    <span class="moment-survole">Oser essayer augmenter sa confiance en soi. Le cheval vous fera alors confiance car il est comme votre reflet dans un miroir.</span>
                </span>
                <span class="survole">Solidarité,
                    <span class="moment-survole">Entraide partage échange de ses compétences et savoirs pour aider les autres.</span>
                </span>
                <span class="survole">Sécurité,
                    <span class="moment-survole">Prendre du plaisir dans les activités tout en respectant.</span>
                </span>
            </h2>
        </div>
    </div>
    <div id = "inscription">
        <img alt="Cliquez ici" onclick="openPopup()" id = "inscription1" src="images/profil.png"/>
        
    </div>  
    <div id="popup" class="popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h2 id="form-title">Formulaire d'inscription</h2>
        <form id="popup-form">
            <div id="name-fields">
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" required>

                <label for="surname">Prénom :</label>
                <input type="text" id="surname" name="surname" required>

            </div>
            
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
            
            <div id="info-fields">
                <label for="phone">Numéro de téléphone :</label>
                <input type="tel" id="phone" name="phone" required>
            </div>

            <div id="password-fields">
                <label for="password">Mot de passe :</label>
                <textarea id="password" name="password" required></textarea>

                <label for="passwordverif">Vérification du Mot de passe :</label>
                <textarea id="passwordverif" name="passwordverif" required></textarea>
            </div>

            <button class="boutonpop" type="submit">Envoyer</button><br>
            <button class="boutonpop" type="button" id="toggle-button" onclick="switchToLogin()">se connecter</button>
        </form>
    </div>
</div>
    </div> 


