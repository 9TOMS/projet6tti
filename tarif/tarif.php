<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tarif.css">
    <script defer src="tarif.js"></script>
    <title>Accueil</title>
</head>
<body>
    <?php include("entete.php"); ?>

    <div class="contenu">
        <?php include("menu.php"); ?>

        <!-- Colonne des stages -->
        <div class="colonnestages">
            <h2>Formulaires Stages</h2>
            
            <div class="carousel">
                <div class="carousel-items">
                    <div class="carousel-item" style="background-color: lightcoral;">
                        <form id="form-stage1">
                            <h2>Stage 1</h2>
                            <br>
                            <p>Description :
                            <br>Age requis:
                            <br>Dates:
                            <br>Activités prevues :
                            <br>
                            </p>
                            <label for="nom">Nom :</label>
                            <input type="text" id="nom" name="nom" required>
                            <label for="prenom">Prénom :</label>
                            <input type="text" id="prenom" name="prenom" required>
                            <label for="email">Email :</label>
                            <input type="email" id="email" name="email" required>
                            <label for="telephone">Téléphone :</label>
                            <input type="tel" id="telephone" name="telephone" required>
                            <button type="submit">S'inscrire</button>
                        </form>
                    </div>
                    <div class="carousel-item" style="background-color: lightseagreen;">
                        <form id="form-stage2">
                            <h2>Stage 2</h2>
                            <br>
                            <p>Description :
                            <br>Age requis:
                            <br>Dates:
                            <br>Activités prevues :
                            <br>
                            </p>
                            <label for="nom">Nom :</label>
                            <input type="text" id="nom" name="nom" required>
                            <label for="prenom">Prénom :</label>
                            <input type="text" id="prenom" name="prenom" required>
                            <label for="email">Email :</label>
                            <input type="email" id="email" name="email" required>
                            <label for="telephone">Téléphone :</label>
                            <input type="tel" id="telephone" name="telephone" required>
                            <button type="submit">S'inscrire</button>
                        </form>
                    </div>
                    <div class="carousel-item" style="background-color: lightblue;">
                        <form id="form-stage3">
                            <h2>Stage 3</h2>
                            <br>
                            <p>Description :
                            <br>Age requis:
                            <br>Dates:
                            <br>Activités prevues :
                            <br>
                            </p>
                            <label for="nom">Nom :</label>
                            <input type="text" id="nom" name="nom" required>
                            <label for="prenom">Prénom :</label>
                            <input type="text" id="prenom" name="prenom" required>
                            <label for="email">Email :</label>
                            <input type="email" id="email" name="email" required>
                            <label for="telephone">Téléphone :</label>
                            <input type="tel" id="telephone" name="telephone" required>
                            <button type="submit">S'inscrire</button>
                        </form>
                    </div>
                </div>
                <!-- Flèche gauche -->
                <button class="carousel-arrow left">&lt;</button>
                <!-- Flèche droite -->
                <button class="carousel-arrow right">&gt;</button>
            </div>


        </div>
        <!-- Colonne formulaire des cours -->
        <div class="colonnecours">
            <h2>Formulaire d'inscription - Cours</h2>
            <form id="form-cours">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
                <label for="telephone">Téléphone :</label>
                <input type="tel" id="telephone" name="telephone" required>
                <button type="submit">S'inscrire</button>
            </form>
        </div>

        <!-- Colonne formulaire des balades -->
        <div class="colonnebalades">
            <h2>Formulaire d'inscription - Balades</h2>
            <form id="form-balades">
                <label for="nom-balade">Nom :</label>
                <input type="text" id="nom-balade" name="nom" required>
                <label for="prenom-balade">Prénom :</label>
                <input type="text" id="prenom-balade" name="prenom" required>
                <label for="email-balade">Email :</label>
                <input type="email" id="email-balade" name="email" required>
                <label for="telephone-balade">Téléphone :</label>
                <input type="tel" id="telephone-balade" name="telephone" required>
                <button type="submit">S'inscrire</button>
            </form>
        </div>
    </div>

    <?php include("pied_de_page.php"); ?>
</body>
</html>
