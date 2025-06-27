<?php
date_default_timezone_set('Europe/Brussels');
$date_depart = date("H:i:s");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css.css"/>
    <script src="java.js" defer></script>
    <title>Contrôle fonction</title>
</head>
<body>
    <div id="entete">
        <div id="text1">Jeu de recherche d'un nombre choisi aléatoirement par le programme</div>
    </div>

    <div id="intituler">
        <script>
            document.getElementById('intituler').innerHTML = "Vous devez trouver un nombre entre 1 et 1024";
        </script>
    </div>

    <br>

    <div id="input"> 
        <input type="number" id="nbr" placeholder="Entrez un nombre">
        <input type="submit" value="Tester" onclick="test()">
    </div>

    <p id="heure_de_depart">Heure de départ : <?php echo $date_depart; ?></p>
    <div class="heure_actuelle">Heure actuelle : <span id="heure_actuelle"><?php echo $date_depart; ?></span></div>

    <p id="duree_partie"></p>

    <div id="pied">
        <div id="text2"></div>
    </div>
</body>
</html>