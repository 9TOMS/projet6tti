<link rel="stylesheet" href="news.css">
<script defer src="tarif.js"></script>
<?php include("entete.php"); ?>

<div class="Contenu">
    <?php include("menu.php"); ?>
<div id="grand_contenaire">
    <!-- Flèche gauche -->
    <button class="carousel-arrow left">&lt;</button>
    <?php include("includenews.php") ?>
    <?php include("includenews.php") ?>
    <!-- Flèche droite -->
        <button class="carousel-arrow right">&gt;</button>
</div>
</div>

<?php include("pied_de_page.php"); ?>
