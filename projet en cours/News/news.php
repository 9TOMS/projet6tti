<link rel="stylesheet" href="news.css">
<script defer src="news.js"></script>
<?php include("entete.php"); ?>

<div class="Contenu">
    <?php include("menu.php"); ?>
    <div class="grand_contenaire">
        <!-- Flèche gauche -->
        <button class="carousel-arrow left" onclick="precedenteslide()">&lt;</button>
        <div class="carousel">
            <div class="carousel-items">
                <?php 
                for ($i = 1; $i <= 5; $i++) { 
                    echo '<div class="news-item" id="news-' . $i . '">';
                    include("includenews.php"); 
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <!-- Flèche droite -->
        <button class="carousel-arrow right" onclick="prochaineslide()">&gt;</button>
    </div>
</div>
<?php include("pied_de_page.php"); ?>
