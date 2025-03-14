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
                                        <?php
                        $color=['lightcoral','lightseagreen','lightblue'];
                        for ($i=1; $i<4; $i++){
                    ?>
                    <div class="carousel-item" style="background-color: <?php echo $color[$i-1];?>;">
                        <form id="form-stage<?php echo $i;?>">
                            <h2>Stage <?php echo $i;?></h2>
                            <br>
                            <p>Description :
                            <br>Age requis:
                            <br>Dates:
                            <br>Activités prevues :
                            <br>
                            <br>
                            </p>
                            <h2>Inscription</h2>
                            <label for="nom">Nom :</label>
                            <input type="text" id="nom" name="nom" required>
                            <label for="prenom">Prénom :</label>
                            <input type="text" id="prenom" name="prenom" required>
                            <label for="email">Email :</label>
                            <input type="email" id="email" name="email" required>
                            <label for="nombredepersonne">Nombre de personne :</label>
                            <input type="number" id="nombredepersonne" name="nombredepersonne" min="1" required>
                            <button type="submit">S'inscrire</button>
                        </form>
                    </div>
                    <?php } ?>
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
                <label for="nombredepersonne">Nombre de personne :</label>
                <input type="number" id="nombredepersonne" name="nombredepersonne" min="1" required>
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
                <label for="nombredepersonne">Nombre de personne :</label>
                <input type="number" id="nombredepersonne" name="nombredepersonne" min="1" required>
                <button type="submit">S'inscrire</button>
            </form>
        </div>
    </div>

    <?php include("pied_de_page.php"); ?>
</body>
</html>

