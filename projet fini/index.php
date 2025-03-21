<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <script defer src="java.js"></script>
</head>
<body>
    <?php include("entete.php"); ?>
    <div class="page">
        <?php include("menu.php"); ?>
        <?php include("includenews.php") ?> 

        <script>
            document.getElementsByClassName('commentaire')[0].style.visibility="hidden";
            document.getElementsByClassName('commentaire')[0].style.position="fixed";
            document.getElementsByClassName('pdfnews')[0].style.width="900px";
            document.getElementsByClassName('pdfnews')[0].style.height="405px";
        </script>

        <div class="info_acceuil">
            <div class="activites_acceuil">
                <h3>Activités</h3>
                <p>Prochaine activitée :</p>
                <p>Nom de l'activitée :</p>
                <p>Date de l'activité :</p>
                <p>Nombre de places restantes :</p>
            </div>
            <div class="contact_accueil">
                <h3>Contact</h3>
                <p>N° tel : <a target="_blank" href="tel:+0476 94 93 60"> 0460 565 420</a></p>
                <p>Email : <a target="_blank" href="mailto:claudelheh@gmail.com">claudelheh@gmail.com</a></p>
                <p>Facebook: <a target="_blank" href="https://www.facebook.com/asblcrepuscule">Crépuscule</a></p>
            </div>
        </div>
    </div>
    <?php include("pied_de_page.php"); ?>
</body>
</html>