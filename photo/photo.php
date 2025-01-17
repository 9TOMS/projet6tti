<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="photo.css" rel="stylesheet">
    <title>Photo</title>
</head>
<body>
<?php include("tete.php"); ?>
<div id = "corps">
    <?php include("menu.php"); ?>
    <div id="photo">    
        <h1>Photo</h1>
        <div id = "album">
            <div id = "album1">
                <h2>Nom 1 + Date 1</h2>
                <div id = "photo1">
                    <div class="arrow" id="left-arrow">&lt;</div>
                    <img class="image" src="images/logo.png" >
                    <img class="image" src="images/mail.png" >
                    <img class="image" src="images/facebook.png" >
                    <img class="image" src="images/mail.png" >
                    <div class="arrow" id="right-arrow">&gt;</div>
                </div>
            </div>
            <div id = "album2">
                <h2>Nom 2 + Date 2</h2>
                <div id = "photo1">
                    <div class="arrow" id="left-arrow">&lt;</div>
                    <img class="image" src="images/logo.png" >
                    <img class="image" src="images/mail.png" >
                    <img class="image" src="images/logo.png" >
                    <div class="arrow" id="right-arrow">&gt;</div>
                </div>
            </div>
        </div>    
    </div>
</div>  
<?php include("pied_de_page.php"); ?>
</body>

