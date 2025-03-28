<?php
$bdd = mysqli_connect('localhost','root','','crepuscule'); // Correction du nom de la base de données

if (!$bdd) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!mysqli_set_charset($bdd, "utf8")) {
    echo "Erreur lors du chargement du jeu de caractères utf8 : ", mysqli_error($bdd);
    exit();
}
?>
<div class="news_poste marge">
    <div class="top">
        <div class="gauche">Text</div>
        <div class="droite">Date</div>
    </div>
    <div class="imagenews pdfnews-container calendar-container iframe-shadow">
        <?php
        // Transformation de l'URL pour l'intégration
        $embedUrl = str_replace('/pub?', '/embed?', $imageSrc);
        ?>
        <iframe src="<?php echo htmlspecialchars($embedUrl); ?>"
                frameborder="0" class="pdfnews" 
                allowfullscreen="true" mozallowfullscreen="true" 
                webkitallowfullscreen="true" width="100%" height="250px"></iframe>
    </div>
    <div class="bas">
        <div class="coeur">❤️</div>
        <div class="partage">➤</div>
    </div>

    <div class="commentaire">
        <div class="commentaire-item">
            <div class="avatar"></div>
            <div class="texte">Trop beau le cheval</div>
            <div class="date">Date</div>
        </div>
        <div class="commentaire-item">
            <div class="avatar"></div>
            <div class="texte">Hâte de venir rencontrer ces chevaux...</div>
            <div class="date">Date</div>
        </div>
        <div class="commentaire-item">
            <div class="avatar"></div>
            <div class="texte">Comment on s'inscrit</div>
            <div class="date">Date</div>
        </div>

        <div class="ecrire-commentaire">
            <input type="text" placeholder="Écrire un commentaire...">
            <button>➤</button>
        </div>
    </div>
</div>
