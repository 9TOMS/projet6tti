<div id="entete">
    <style>
        form{
            text-align: center;
        }
        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        form input{
            width: calc(100% - 5px);
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form button {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }



        .boutonpop {
            margin: 5px;
        }
    </style>
    <link rel="stylesheet" href="main.css">
    <script defer src="java.js"></script>
    <div id="logo_entete">
        <a href="index.php"><img id="img_logo" src="images/logo.png"></a>
    </div>
    <div id="titre_entete">
        <div id="titre_nom">Crépuscule</div>
        <div id="titre_citation">
            <span class="info_bulle_entete">Respect,
                <span class="info_bulle_entete-text">Respect des autres membres du club, des moniteurs et responsables,
                    des consignes, du matériel et des infrastructures mais aussi et surtout des chevaux.</span>
            </span>
            <span class="info_bulle_entete">Confiance,
                <span class="info_bulle_entete-text">Oser essayer augmenter sa confiance en soi. Le cheval vous fera
                    alors confiance car il est comme votre reflet dans un miroir.</span>
            </span>
            <span class="info_bulle_entete">Solidarité,
                <span class="info_bulle_entete-text">Entraide partage échange de ses compétences et savoirs pour aider
                    les autres.</span>
            </span>
            <span class="info_bulle_entete">Sécurité
                <span class="info_bulle_entete-text">Prendre du plaisir dans les activités tout en respectant.</span>
            </span>
        </div>
    </div>
    <div id="inscription_entete">
        <img alt="Cliquez ici" onclick="openPopup()" id="img_inscription" src="images/profil.png" />
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
                    <input type="password" id="password" name="password" required></input>

                    <label for="passwordverif">Vérification du Mot de passe :</label>
                    <input type="password" id="passwordverif" name="passwordverif" required></input>
                </div>

                <button class="boutonpop" type="submit">Envoyer</button><br>
                <button class="boutonpop" type="button" id="toggle-button" onclick="switchToLogin()">Se
                    connecter</button>
            </form>
        </div>
    </div>
</div>