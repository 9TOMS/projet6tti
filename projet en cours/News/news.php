<?php
$bdd = mysqli_connect('localhost', 'root', '', 'crepuscule');

if (!$bdd) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!mysqli_set_charset($bdd, "utf8")) {
    echo "Erreur lors du chargement du jeu de caractères utf8 : ", mysqli_error($bdd);
    exit();
}

session_start();
$isAdmin = true;
 
// Traitement du formulaire de commentaires
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_commentaire'])) {
    $id_news = mysqli_real_escape_string($bdd, $_POST['Id_News']);
    $id_membre = mysqli_real_escape_string($bdd, $_POST['Id_membre']);
    $contenu_commentaire = mysqli_real_escape_string($bdd, $_POST['commentaire']);

    if (!empty($contenu_commentaire)) {
        $insertQuery = "INSERT INTO commentaires_news (Id_News, Id_Membre, Contenu_Commentaire)
                        VALUES ('$id_news', '$id_membre', '$contenu_commentaire')";
        if (!mysqli_query($bdd, $insertQuery)) {
            echo "<p style='color:red;'>Erreur : " . mysqli_error($bdd) . "</p>";
        }
    }
}
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
            <div style="display: block;">
                <button onclick="document.getElementById('form-ajout-news').classList.toggle('hidden');"
                        style="background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">
                    ➕ Ajouter une news
                </button>
            </div>
            
            <form id="form-ajout-news" class="hidden" method="POST" action="ajouter_news.php" enctype="multipart/form-data" 
                style="position: fixed; margin-top: 45px; flex-direction: column; gap: 10px; background: #f9f9f9; padding: 5px; border-radius: 8px; z-index: 30; width:50%">
                
                <!-- Choix du type de média -->
                <fieldset style="border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                    <legend>Type de média :</legend>
                    <label style=" align-items: center; gap: 5px; margin-bottom: 5px;">
                        <input type="radio" name="media_type" value="google_slides" checked onchange="toggleMediaInputs()">
                        Google Slides
                    </label>
                    <label style=" align-items: center; gap: 5px;">
                        <input type="radio" name="media_type" value="image" onchange="toggleMediaInputs()">
                        Image (upload)
                    </label>
                </fieldset>

                <!-- Champ pour Google Slides -->
                <div id="google-slides-section">
                    <label for="photo_news">Lien Google Slides :</label>
                    <input 
                        type="url" 
                        name="photo_news" 
                        id="photo_news" 
                        placeholder="https://docs.google.com/presentation/d/..." 
                        pattern="^https:\/\/docs\.google\.com\/presentation\/d\/e\/[a-zA-Z0-9_-]+\/pub\?start=false&loop=false&delayms=3000$"
                        style="padding: 8px;"
                        title="Veuillez entrer un lien Google Slides valide"
                    />
                </div>

                <!-- Champ pour upload d'image -->
                <div id="image-section" style="display: none;">
                    <label for="image_upload">Image :</label>
                    <input 
                        type="file" 
                        name="image_upload" 
                        id="image_upload" 
                        accept="image/*"
                        style="padding: 8px;"
                    />
                    <small style="color: #666;">Formats acceptés : JPG, PNG, GIF (max 5MB)</small>
                </div>

                <label for="info_news">Titre :</label>
                <input type="text" name="info_news" id="info_news" required placeholder="Résumé de la news" style="padding: 8px;">

                <script>
                    function toggleMediaInputs() {
                        const mediaType = document.querySelector('input[name="media_type"]:checked').value;
                        const googleSlidesSection = document.getElementById('google-slides-section');
                        const imageSection = document.getElementById('image-section');
                        const photoNewsInput = document.getElementById('photo_news');
                        const imageUploadInput = document.getElementById('image_upload');

                        if (mediaType === 'google_slides') {
                            googleSlidesSection.style.display = 'block';
                            imageSection.style.display = 'none';
                            photoNewsInput.required = true;
                            imageUploadInput.required = false;
                        } else {
                            googleSlidesSection.style.display = 'none';
                            imageSection.style.display = 'block';
                            photoNewsInput.required = false;
                            imageUploadInput.required = true;
                        }
                    }

                    document.getElementById('form-ajout-news').addEventListener('submit', function (e) {
                        const mediaType = document.querySelector('input[name="media_type"]:checked').value;
                        
                        if (mediaType === 'google_slides') {
                            const input = document.getElementById('photo_news');
                            const url = input.value.trim();
                            const regex = /^https:\/\/docs\.google\.com\/presentation\/d\/e\/[a-zA-Z0-9_-]+\/pub\?start=false&loop=false&delayms=3000$/;

                            if (!regex.test(url)) {
                                e.preventDefault();
                                alert("❌ Lien Google Slides invalide. Il doit être au format exact : https://docs.google.com/presentation/d/e/.../pub?start=false&loop=false&delayms=3000");
                                input.focus();
                                return;
                            }
                        } else if (mediaType === 'image') {
                            const imageInput = document.getElementById('image_upload');
                            if (!imageInput.files.length) {
                                e.preventDefault();
                                alert("❌ Veuillez sélectionner une image.");
                                imageInput.focus();
                                return;
                            }
                            
                            // Vérification de la taille du fichier (5MB max)
                            const file = imageInput.files[0];
                            if (file.size > 5 * 1024 * 1024) {
                                e.preventDefault();
                                alert("❌ L'image est trop volumineuse (max 5MB).");
                                return;
                            }
                        }
                    });
                </script>

                <?php
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    $info_news = trim($_POST['info_news']);
                    $media_type = $_POST['media_type'];
                    
                    if ($media_type === 'google_slides') {
                        $photo_news = trim($_POST['photo_news']);
                        $pattern = "/^https:\/\/docs\.google\.com\/presentation\/d\/e\/[a-zA-Z0-9_-]+\/pub\?start=false&loop=false&delayms=3000$/";
                        
                        if (!preg_match($pattern, $photo_news)) {
                            die("❌ Erreur : Lien Google Slides invalide. Soumission rejetée.");
                        }
                        
                        // Traitement pour Google Slides
                        // $media_content = $photo_news;
                        
                    } else if ($media_type === 'image') {
                        // Traitement de l'upload d'image
                        if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
                            $upload_dir = 'uploads/';
                            
                            // Créer le dossier s'il n'existe pas
                            if (!is_dir($upload_dir)) {
                                mkdir($upload_dir, 0755, true);
                            }
                            
                            $file_info = pathinfo($_FILES['image_upload']['name']);
                            $file_extension = strtolower($file_info['extension']);
                            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                            
                            if (!in_array($file_extension, $allowed_extensions)) {
                                die("❌ Erreur : Format de fichier non autorisé.");
                            }
                            
                            // Générer un nom unique pour le fichier
                            $file_name = uniqid() . '.' . $file_extension;
                            $file_path = $upload_dir . $file_name;
                            
                            if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $file_path)) {
                                // $media_content = $file_path;
                                // echo "✅ Image uploadée avec succès : " . $file_path;
                            } else {
                                die("❌ Erreur lors de l'upload de l'image.");
                            }
                        } else {
                            die("❌ Erreur : Aucune image sélectionnée ou erreur d'upload.");
                        }
                    }
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
                    $query = "SELECT Id_News, Photo_News, Info_News, Date_News, Nombre_Likes, Media_Type FROM news ORDER BY Id_News DESC";
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
                        $media_type = $row['Media_Type'] ?? 'google_slides'; // Par défaut si la colonne n'existe pas encore
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
                                    <?php if ($media_type === 'google_slides'): ?>
                                        <?php
                                        // Transformation de l'URL pour l'intégration Google Slides
                                        $embedUrl = str_replace('/pub?', '/embed?', $imagenews);
                                        ?>
                                        <iframe src="<?php echo htmlspecialchars($embedUrl); ?> " style=" display: flex; width: 100%; height: 40vh;
                                                frameborder="0" class="pdfnews" id="pdfnews-<?php echo $idnews; ?>" 
                                                allowfullscreen="true" mozallowfullscreen="true" 
                                                webkitallowfullscreen="true"></iframe>
                                    <?php elseif ($media_type === 'image'): ?>
                                        <?php if (file_exists($imagenews)): ?>
                                            <img src="<?php echo htmlspecialchars($imagenews); ?>" 
                                                alt="<?php echo htmlspecialchars($titrenews); ?>"
                                                style="width: 100%; height: auto; max-height: 500px; object-fit: contain; border-radius: 8px;"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                            <div style="display: none; padding: 20px; text-align: center; background-color: #f0f0f0; border-radius: 8px; color: #666;">
                                                ❌ Image non trouvée
                                            </div>
                                        <?php else: ?>
                                            <div style="padding: 20px; text-align: center; background-color: #f0f0f0; border-radius: 8px; color: #666;">
                                                ❌ Image non trouvée : <?php echo htmlspecialchars(basename($imagenews)); ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div style="padding: 20px; text-align: center; background-color: #f0f0f0; border-radius: 8px; color: #666;">
                                            ❓ Type de média non reconnu
                                        </div>
                                    <?php endif; ?>
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