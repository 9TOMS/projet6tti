<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <script src="script.js"></script>
 
    <title>Accueil</title>
</head>
<body>
<?php
    include("entete.php"); 
?>
<div class="Contenu">
    <?php
        include("menu.php");
    ?>
    <div class="publication">
        <p>Futures publications</p>
    </div>
    <div class="autres">
        <div class="activites">
            <h3>Activités</h3>
            <p>Prochaine activitée :</p>
            <p>Nom de l'activitée :</p>
            <p>Date de l'activité :</p>
            <p>Nombre de places restantes :</p>
        </div>
        <div class="contact">
            <h3>Contact</h3>
            <p>N° tel : 0460 565 420</p>
            <p>Email : claudelheh@gmail.com</p>
            <p>Facebook: Crépuscule</p>
        </div>
    </div>
</div>
<?php   include("pied_de_page.php"); 
?>
</body>
