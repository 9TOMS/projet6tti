<?php
$bdd = mysqli_connect('localhost', 'root', '', 'crepuscule');

if (!$bdd) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!mysqli_set_charset($bdd, "utf8")) {
    echo "Erreur lors du chargement du jeu de caractères utf8 : ", mysqli_error($bdd);
    exit();
}

// Traitement du formulaire avant tout affichage HTML
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_commentaire'])) {
    $id_news = mysqli_real_escape_string($bdd, $_POST['id_news']);
    $id_membre = mysqli_real_escape_string($bdd, $_POST['id_membre']);
    $contenu_commentaire = mysqli_real_escape_string($bdd, $_POST['commentaire']);

    if (!empty($contenu_commentaire)) {
        $insertQuery = "INSERT INTO commentaires_news (Id_News, Id_Membre, Contenu_Commentaire)
                        VALUES ('$id_news', '$id_membre', '$contenu_commentaire')";
        if (!mysqli_query($bdd, $insertQuery)) {
            echo "<p style='color:red;'>Erreur : " . mysqli_error($bdd) . "</p>";
        }
    }
}

session_start();
$isAdmin = true;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="java.js"></script>
    <title>Accueil</title>
    <style>
        .grand_contenaire {
            width: calc(100vw - 225px);
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .carousel {
            position: relative;
            width: calc(100% - 100px);
            overflow: hidden;
        }

        .carousel-items {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .news-item {
            min-width: 48.3%;
            box-sizing: border-box;
            margin: 10px;
            overflow-y: auto;
            height: calc(100vh - 255px);
        }

        .carousel-arrow {
            position: absolute;
            top: 49%;
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
        .commentaire-item .texte {
            flex: 1;
            background-color: white;
            padding: 5px 10px;
            border-radius: 25px;
        }
        .commentaire-item {
            display: block;
        }
        .infos_comm {
            display:flex;
            justify-content: space-between;
        }
        .form-commentaire{
            width: 100%;
            display:flex;
        }
        .Likes{
            display:flex;
        }
        .hidden {
        display: none;
    }
    </style>
</head>

<body>
    <?php include("entete.php"); ?>
        
    <div class="page">
        <?php include("menu.php"); ?>
        <div id="page2">
            <?php if ($isAdmin): ?>
                <div style="display : block; ">
                    <button onclick="document.getElementById('form-ajout-news').classList.toggle('hidden');"
                            style="background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">
                        ➕ Ajouter une news
                    </button>
                </div>
                <form id="form-ajout-news" class="hidden" method="POST" action="ajouter_news.php" style=" position: fixed; margin-top: 15px; flex-direction: column; gap: 10px; background: #f9f9f9; padding: 15px; border-radius: 8px; z-index : 30;">
                        <label for="photo_news">Lien Google Sides :</label>
                        <input 
                        type="url" 
                        name="photo_news" 
                        id="photo_news" 
                        required 
                        placeholder="https://docs.google.com/presentation/d/..." 
                        pattern="^https:\/\/docs\.google\.com\/presentation\/d\/e\/[a-zA-Z0-9_-]+\/pub\?start=false&loop=false&delayms=3000$"
                        style="padding: 8px;"
                        title="Veuillez entrer un lien Google Slides valide du type: https://docs.google.com/presentation/d/e/.../pub?start=false&loop=false&delayms=3000"
                        />
                        <label for="info_news">Titre :</label>
                        <input type="text" name="info_news" id="info_news" required placeholder="Résumé de la news" style="padding: 8px;">

                        <script>
                            document.getElementById('form-ajout-news').addEventListener('submit', function (e) {
                                const input = document.getElementById('photo_news');
                                const url = input.value.trim();
                                const regex = /^https:\/\/docs\.google\.com\/presentation\/d\/e\/[a-zA-Z0-9_-]+\/pub\?start=false&loop=false&delayms=3000$/;

                                if (!regex.test(url)) {
                                    e.preventDefault(); // Block the form
                                    alert("❌ Lien Google Slides invalide. Il doit être au format exact : https://docs.google.com/presentation/d/e/.../pub?start=false&loop=false&delayms=3000");
                                    input.focus();
                                }
                            });
                        </script>

                        <?php
                            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                                $photo_news = trim($_POST['photo_news']);
                                $info_news = trim($_POST['info_news']);

                                $pattern = "/^https:\/\/docs\.google\.com\/presentation\/d\/e\/[a-zA-Z0-9_-]+\/pub\?start=false&loop=false&delayms=3000$/";

                                if (!preg_match($pattern, $photo_news)) {
                                    die("❌ Erreur : Lien Google Slides invalide. Soumission rejetée.");
                                }

                                // ✅ Continuer avec le traitement et stockage
                                // ex: insert into DB etc...
                            }
                        ?>

                        <button type="submit" name="submit_news" style="background-color: green; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">
                            Publier la news
                        </button>
                </form>
            <?php endif; ?>
            <div class="grand_contenaire">
                <!-- Flèche gauche -->
                <button class="carousel-arrow left" onclick="precedenteslide()">&lt;</button>

                <div class="carousel">
                    <?php
                    // Récupérer toutes les news
                    $query = "SELECT Id_News, Photo_News, Info_News, Date_News, Nombre_Likes FROM news ORDER BY Id_News DESC";
                    $result = mysqli_query($bdd, $query);
                    $newsItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    $nombreTotalNews = count($newsItems);
                    ?>
                    <div class="carousel-items" id="myElement" data-variable="<?php echo $nombreTotalNews; ?>">
                        <?php foreach ($newsItems as $row) {
                            $idnews = $row['Id_News'];
                            $imagenews = $row['Photo_News'];
                            $titrenews = $row['Info_News'];
                            $datenews = $row['Date_News'];
                            $nombrelikes = $row['Nombre_Likes'];
                            ?>
                            <div class="news-item" id="news-<?php echo $idnews; ?>">
                                <div class="news_poste marge">
                                    <?php if ($isAdmin): ?>
                                        <form method="POST" action="supprimer_news.php" onsubmit="return confirm('Voulez-vous vraiment supprimer cette news ?');" style="margin-top:10px;">
                                            <input type="hidden" name="id_news" value="<?php echo $idnews; ?>">
                                            <button type="submit" style="background-color: red; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">
                                                Supprimer la news
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <div class="top">
                                        <div class="gauche"><?php echo htmlspecialchars($titrenews); ?></div>
                                        <div class="droite"><?php echo htmlspecialchars($datenews); ?></div>
                                    </div>

                                    <div class="imagenews pdfnews-container calendar-container iframe-shadow">
                                        <?php
                                        // Transformation de l'URL pour l'intégration
                                        $embedUrl = str_replace('/pub?', '/embed?', $imagenews);
                                        ?>
                                        <iframe src="<?php echo htmlspecialchars($embedUrl); ?>"
                                                frameborder="0" class="pdfnews" id="pdfnews" 
                                                allowfullscreen="true" mozallowfullscreen="true" 
                                                webkitallowfullscreen="true"></iframe>
                                    </div>
                                    <div class="bas">
                                        <div class="Likes">
                                            <div class="coeur" style="cursor:pointer;">❤️</div>
                                            <div class="compteur_likes"><?php echo htmlspecialchars($nombrelikes); ?></div>
                                        </div>
                                        <div class="partage">➤</div>
                                    </div>
                                    <?php 
                                    $commentQuery = "SELECT m.Nom_Membre, c.Contenu_Commentaire, c.Date_Commentaire 
                                                    FROM commentaires_news c
                                                    JOIN membre m ON c.Id_Membre = m.ID_Membre
                                                    WHERE c.Id_News = $idnews
                                                    ORDER BY c.Id_Commentaire DESC";
                                    $commentResult = mysqli_query($bdd, $commentQuery);
                                    
                                    if (!$commentResult) {
                                        die("Erreur dans la requête: " . mysqli_error($bdd));
                                    }
                                    
                                    $commitems = mysqli_fetch_all($commentResult, MYSQLI_ASSOC);
                                    ?>
                                    <div class="commentaire">
                                        <?php foreach ($commitems as $row): ?>
                                            <div class="commentaire-item">
                                                <div class="infos_comm">
                                                    <div class="pseudo"><?php echo htmlspecialchars($row['Nom_Membre']); ?></div>
                                                    <div class="date"><?php echo htmlspecialchars($row['Date_Commentaire']); ?></div>
                                                </div>
                                                <div class="texte"><?php echo htmlspecialchars($row['Contenu_Commentaire']); ?></div>
                                                
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="ecrire-commentaire">
                                        <form id="form-commentaire-<?php echo $idnews; ?>" class="form-commentaire" data-news-id="<?php echo $idnews; ?>">
                                            <input type="hidden" name="id_news" value="<?php echo $idnews; ?>">
                                            <input type="hidden" name="id_membre" value="2"> <!-- À remplacer dynamiquement -->
                                            <input type="text" name="commentaire" placeholder="Écrire un commentaire..." required>
                                            <button type="submit">➤</button>
                                        </form>
                                    </div>
                                    <div id="message-<?php echo $idnews; ?>" class="message"></div>
                                    <script>
                                       // Fonction principale pour initialiser les gestionnaires de commentaires
                                        function initCommentForms() {
                                            // Sélectionne tous les formulaires de commentaire
                                            const commentForms = document.querySelectorAll('.form-commentaire');
                                            
                                            // Ajoute un écouteur d'événement à chaque formulaire
                                            commentForms.forEach(form => {
                                                form.addEventListener('submit', handleCommentSubmit);
                                            });
                                        }

                                        // Gère la soumission du formulaire
                                        function handleCommentSubmit(event) {
                                            event.preventDefault();
                                            event.stopPropagation(); // Empêche la propagation de l'événement

                                            const form = event.target;
                                            
                                            // Si le formulaire est déjà en cours de traitement, on ne fait rien
                                            if (form.hasAttribute('data-processing')) {
                                                return;
                                            }

                                            // Marque le formulaire comme "en cours de traitement"
                                            form.setAttribute('data-processing', 'true');
                                            
                                            // Désactive le bouton pour éviter les clics multiples
                                            const submitButton = form.querySelector('button[type="submit"]');
                                            submitButton.disabled = true;

                                            // Récupère les données du formulaire
                                            const formData = new FormData(form);
                                            const newsId = form.dataset.newsId;
                                            const messageDiv = document.getElementById(`message-${newsId}`);

                                            // Envoie la requête AJAX
                                            fetch('ajouter_commentaire.php', {
                                                method: 'POST',
                                                body: formData
                                            })
                                            .then(response => {
                                                if (!response.ok) {
                                                    throw new Error('Erreur réseau');
                                                }
                                                return response.json();
                                            })
                                            .then(data => {
                                                if (data.success) {
                                                    // Ajoute le nouveau commentaire à la liste
                                                    addNewComment(form, data);
                                                    // Réinitialise le champ de texte
                                                    form.querySelector('input[name="commentaire"]').value = '';
                                                    // Affiche un message de succès
                                                    showMessage(messageDiv, 'Commentaire ajouté !', 'success');
                                                } else {
                                                    // Affiche un message d'erreur
                                                    showMessage(messageDiv, 'Erreur : ' + data.error, 'error');
                                                }
                                            })
                                            .catch(error => {
                                                console.error('Erreur:', error);
                                                showMessage(messageDiv, 'Une erreur est survenue', 'error');
                                            })
                                            .finally(() => {
                                                // Réactive le bouton et supprime l'attribut de traitement
                                                submitButton.disabled = false;
                                                form.removeAttribute('data-processing');
                                            });
                                        }

                                        // Ajoute un nouveau commentaire à l'affichage
                                        function addNewComment(form, data) {
                                            const commentList = form.closest('.news-item').querySelector('.commentaire');
                                            const newComment = `
                                                <div class="commentaire-item">
                                                    <div class="infos_comm">
                                                        <div class="pseudo">${data.nom_membre}</div>
                                                        <div class="date">${data.date_commentaire}</div>
                                                    </div>
                                                    <div class="texte">${data.contenu}</div>
                                                </div>
                                            `;
                                            commentList.insertAdjacentHTML('afterbegin', newComment);
                                        }

                                        // Affiche un message de feedback
                                        function showMessage(element, text, type) {
                                            element.textContent = text;
                                            element.style.color = type === 'success' ? 'green' : 'red';
                                        }

                                        // Initialise les formulaires au chargement de la page
                                        document.addEventListener('DOMContentLoaded', initCommentForms);

                                        // Si le carousel charge dynamiquement des éléments, réinitialisez les écouteurs
                                        function onCarouselUpdate() {
                                            initCommentForms();
                                        }
                                    </script>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- Flèche droite -->
                <button class="carousel-arrow right" onclick="prochaineslide()">&gt;</button>
            </div>
        </div>
    </div>

    <?php include("pied_de_page.php"); ?>
</body>
</html>

<script> //Requete ajax likes
   document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.coeur').forEach(btn => {
        btn.addEventListener('click', () => {
            const newsItem = btn.closest('.news-item');
            const idNews = newsItem.id.split('-')[1];
            const compteur = newsItem.querySelector('.compteur_likes');

            fetch('like.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id_news=${idNews}`
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    compteur.textContent = data.likes;
                    btn.classList.toggle('active', data.action === 'liked');
                } else {
                    alert("Erreur: " + data.error);
                }
            })
            .catch(console.error);
        });
    });
});

</script>
