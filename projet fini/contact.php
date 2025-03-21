<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <script defer src="java.js"></script>
</head>
<body>
<?php include("entete.php"); ?>
<div id = "corps">
<div class="page">
        <?php include("menu.php"); ?>
    <div id="contact">
        <h1 id = "titre_nom_contact">Contactez nous</h1>
        <div id="MethodeDeContact">
            <a target="_blank" id="telephone" href="tel:+0476 94 93 60"> 
                <img id ="ImageTelephone" src="images/gsm.png">
                <h2 id="petit_titre_contact">Par téléphone</h2>
                <p id="info_text">0476 94 93 60</p>
            </a>
            <a target="_blank" id="mail" href="mailto:crepusculeasbl@gmail.com">
                <img id ="ImageMail" src="images/mail.PNG">
                <h2 id="petit_titre_contact">Par mail</h2>
                <p id="info_text">crepusculeasbl@gmail.com</p>
            </a>
            <a target="_blank" id="facebook" href="https://www.facebook.com/asblcrepuscule">
                <img id ="ImageFacebook" src="images/facebook.png" >
                <h2 id="petit_titre_contact">Par facebook</h2>
                <p id="info_text">asblcrepuscule</p>
            </a>
            <a target="_blank" id="localisation">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d41383.75578866085!2d5.404581067169286!3d49.58860773119805!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47ea933f00eafd89%3A0xa9511ace583a63a4!2sSommethonne%2C%206769%20Meix-devant-Virton!5e0!3m2!1sfr!2sbe!4v1732278758887!5m2!1sfr!2sbe" width="250" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <h2 id="petit_titre_contact">Retrouvez nous ici</h2>
                
            </a>
        </div>
    </div>
            </div>
</div>
<?php include("pied_de_page.php"); ?>
</body>