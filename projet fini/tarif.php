<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="java.js"></script>
    <title>Accueil</title>
    <style>
        /* Carrousel flèches */
        .carousel {
            position: relative;
            /* Pour positionner les flèches par rapport au carrousel */
            width: 100%;
            width: 370px;
            height: 435px;
            margin: 10px auto;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background-color: rgba(255, 255, 255, 0.8);
        }

        .carousel-items {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 100%;
            height: 100%;
        }

        .carousel-item {
            min-width: 100%;
            height: 100%;
            color: #333;
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .stage_taille {
            width: 230px;
            padding-left: 60px;
        }

        .stage_taille input {
            width: 230px;
        }

        .stage_taille button {
            width: 247px;
        }

        /* Styles pour les flèches */
        .carousel-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 10;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .carousel-arrow.left {
            left: 10px;
        }

        .carousel-arrow.right {
            right: 10px;
        }

        .carousel-arrow:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }
    </style>
</head>

<body>
    <?php include("entete.php"); ?>

    <div class="page">
        <?php include("menu.php"); ?>

        <!-- Colonne des stages -->
        <div class="colonnestages">
            <div id="titre_formulaire">Formulaires Stages</div>

            <div class="carousel">
                <div class="carousel-items">
                    <?php
                    $color = ['lightcoral', 'lightseagreen', 'lightblue'];
                    for ($i = 1; $i < 4; $i++) {
                        ?>
                        <div class="carousel-item" style="background-color: <?php echo $color[$i - 1]; ?>;">
                            <form id="form-stage<?php echo $i; ?>">
                                <h2>Stage <?php echo $i; ?></h2>
                                <div id="centre"> Pour voir le stage click ici</div>
                                <div class="stage_taille">
                                    <br><label for="nom">Nom :</label>
                                    <input type="text" id="nom" name="nom" required>
                                    <label for="prenom">Prénom :</label>
                                    <input type="text" id="prenom" name="prenom" required>
                                    <label for="email">Email :</label>
                                    <input type="email" id="email" name="email" required>
                                    <label for="nombredepersonne">Nombre de personne :</label>
                                    <input type="number" id="nombredepersonne" name="nombredepersonne" min="1" required>
                                    <button type="submit">S'inscrire</button>
                                </div>
                            </form>
                        </div>
                    <?php } ?>
                </div>
                <!-- Flèche gauche -->
                <button id="carousel-arrow-tarif" class="carousel-arrow left">&lt;</button>
                <!-- Flèche droite -->
                <button id="carousel-arrow-tarif" class="carousel-arrow right">&gt;</button>
            </div>


        </div>
        <!-- Colonne formulaire des cours -->
        <div class="colonnecours">
            <div id="titre_formulaire">Formulaire d'inscription - Cours</div><br><br>
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
            <div id="titre_formulaire">Formulaire d'inscription - Balades</div><br><br>
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