<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentions Légales</title>
    <style>
        body {
            background-image: url('images/MenuFond.png');
            background-size: cover;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            color: #111;
            margin: 0;
            padding: 0;
        }

        .contenu {
            background-color: rgba(200, 246, 217, 0.75); 
            max-width: 800px;
            margin: 80px auto;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        h1, h2 {
            color: #222;
        }

        p {
            line-height: 1.6;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .retour {
            display: block;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <?php include("entete.php"); ?>
    <div class="contenu">
        <h1>Mentions Légales</h1>
        <p><strong>Éditeur du site :</strong>pierrard<br>
       <ul>
<li>Rue d’Arlon, 112<br>
6760 <span class="caps">VIRTON</span></li>
<li>063 58 89 20</li>
<li><a class="yab-email-link" href="mailto:direction@pierrard.be">direction@pierrard.be</a></li>
</ul>
        Email de contact : cdirection@pierrard.be</p>

        <h2>Propriété intellectuelle</h2>
        <p>Le contenu du site est protégé par les lois en vigueur sur la propriété intellectuelle. Toute reproduction sans autorisation est interdite.</p>

        <h2>Données personnelles</h2>
        <p>Les informations collectées via le site sont destinées à un usage interne uniquement. Conformément à la loi « Informatique et Libertés », vous disposez d’un droit d'accès, de rectification et de suppression des données vous concernant.</p>

        <div class="retour">
            <a href="index.php">← Retour à l'accueil</a>
        </div>
    </div>
    <?php include("pied_de_page.php"); ?>
</body>
</html>