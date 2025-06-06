<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo</title>
    <script defer src="java.js"></script>
    <style>
        body {
            background-image: url(images/MenuFond.png);
            background-size: cover;
            background-attachment: fixed;
        }

        #corps {
            display: flex;

        }

        .carousel-wrapper {
            display: flex;
            justify-content: left;
            align-items: center;
            margin-bottom: 20px;
            overflow: hidden;
            width: 80%;
        }

        .carousel-container {
            display: flex;
            transition: transform 0.4s ease-in-out;
        }

        .carousel {
            overflow: hidden;
            border: 2px solid black;
            border-radius: 10px;
            position: relative;
            width: calc(100vw - 260px);
            
        }

        .carousel-track {
            display: flex;
            transition: transform 0.4s ease-in-out;
        }

        .carousel-slide {
            height: 300px;
         /*   display: flex;  retiré*/
            justify-content: center;
            align-items: center;
            background-size: cover;
            background-position: center;
        }

        .carousel-slide img {
           /* width: 100%; retiré*/
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .carousel-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 50%;
            height: 35px;
            width: 35px;
            font-size: large;
        }

        .carousel-button.prev {
            left: 10px;

        }

        .carousel-button.next {
            right: 100px;
        }

        .switch-carousel-button {
            position: relative;
            color: white;
            border: none;
            cursor: pointer;
            height: 35px;
            width: 35px;
            font-size: large;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
        }

        .delete-photo {
            bottom: 100%; /* modifier*/
            background-color: rgba(255, 0, 0, 0.8);
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 16px;
            z-index: 10;
            left: 90%;  /* modifier*/
            position: relative;
        }

        .delete-poste {
            top: 5%;
            left: 87%;
            background-color: rgba(255, 0, 0, 0.8);
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 16px;
            z-index: 10;
            right: 10%;
            position: relative;
        }
        /*animation supression*/
        .fade-out {
            opacity: 0;
            transform: scale(0.9);
            transition: all 0.3s ease;
        }

        .btn-ajouter-publication {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 10%;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-ajouter-photo {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
        }
        .Bouton-droit-alignement{
            margin-bottom: 6%;
            margin-right: 0.5%;
            margin-left: 0.5%;
        }
        .Bouton-gauche-alignement{
            position: absolute;
        }

        /* nouveau */
        .fnd_gris{
            background-color: rgba(186, 230, 228, 0.76);
            display: inline-block;
        padding: 0 10px; /* pour un peu d'espace autour du texte */
        }

      </style>
</head>
<body>
    <?php
    require_once("connexion_bd.php");
    $Admin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;
    $Admin = true; // Test manuel
    ?>
    <?php include("entete.php"); ?>
    <div class="page">
        <?php include("menu.php"); ?>
        <div class="Bouton-droit-alignement">   
            <button class="switch-carousel-button prev">&#10094;</button>
        </div>   
        
          <container>
             <?php if ($Admin): ?>
        <button id="btnAjouterPublication" class="btn-ajouter-publication">Ajout publication</button>
<?php endif; ?>
<div class="carousel-wrapper">
            <div class="publication-header"></div>
            <div class="carousel-container">

                <?php
                $sql = "SELECT photo.*, parent_photo.parent_nom 
                        FROM photo 
                        INNER JOIN parent_photo ON photo.id_parent = parent_photo.id_parent 
                        ORDER BY photo.id_parent ASC, photo.Id_Photo ASC";
                $result = $conn->query($sql);
                $publications = [];

                while ($row = $result->fetch_assoc()) {
                    $idParent = $row['id_parent'];
                    if (!isset($publications[$idParent])) {
                        $publications[$idParent] = [
                            'titre' => $row['parent_nom'],
                            'images' => []
                        ];
                    }
                    $publications[$idParent]['images'][] = $row;
                }

                foreach ($publications as $idParent => $data) {
                    $titrePost = $data['titre'];
                    $images = $data['images']; 
                ?>
                <div class="carousel" data-carousel-id="carousel-<?php echo $idParent; ?>">
    <?php if ($Admin): ?>
        <button class="delete-poste" data-post-id="<?php echo $idParent; ?>">×</button>
    <?php endif; ?>
                    <div>
                        <h2 class="fnd_gris"><?php echo htmlspecialchars($titrePost); ?></h2>
                    </div>
                    <?php if ($Admin): ?>
                        <button class="btn-ajouter-photo" 
                                onclick="showUploadModal(<?php echo $idParent; ?>, 'carousel-<?php echo $idParent; ?>')">
                            Ajouter photo
                        </button>
                    <?php endif; ?>
                    <div class="carousel-track">
                        <?php foreach ($images as $image) { ?>
                            <div class="carousel-slide">
                                <img src="<?php echo $image['Photo_Photo']; ?>" alt="Image">
                                <?php if ($Admin): ?>
                                    <button class="delete-photo" data-photo-id="<?php echo $image['Id_Photo']; ?>">×</button>
                                <?php endif; ?>
                            </div>
                        <?php } ?>
                         
                        </container>
                    </div>
                    <button class="carousel-button prev">&#10094;</button>
                    <button class="carousel-button next">&#10095;</button>
                </div>
                <?php } ?> 
                  <div class="Bouton-gauche-alignement">
             <button class="switch-carousel-button next">&#10095;</button>
        </div>
            </div>
         
        </div>
       
    </div>
    <?php include("pied_de_page.php"); ?>
    <?php include("upload_modal.php"); ?>
    <script>
        const carouselContainer2 = document.querySelector('.carousel-container');
        const carousels = Array.from(carouselContainer2.children);
        const switchPrevButton = document.querySelector('.switch-carousel-button.prev');
        const switchNextButton = document.querySelector('.switch-carousel-button.next');

        let currentCarouselIndex = 0;

        function updateCarouselDisplay() {
            const containerWidth = carousels[0].getBoundingClientRect().width;
            carouselContainer2.style.transform = `translateX(-${currentCarouselIndex * containerWidth}px)`;
        }

        switchNextButton.addEventListener('click', () => {
            currentCarouselIndex = (currentCarouselIndex + 1) % carousels.length;
            updateCarouselDisplay();
        });

        switchPrevButton.addEventListener('click', () => {
            currentCarouselIndex = (currentCarouselIndex - 1 + carousels.length) % carousels.length;
            updateCarouselDisplay();
        });

        const allCarousels = document.querySelectorAll('.carousel');
        allCarousels.forEach(carousel => {
            const track = carousel.querySelector('.carousel-track');
            const slides = Array.from(track.children);
            const prevButton = carousel.querySelector('.carousel-button.prev');
            const nextButton = carousel.querySelector('.carousel-button.next');

            let currentIndex2 = 0;

            function updateTrack() {
                const slideWidth = slides[0].getBoundingClientRect().width;
                track.style.transform = `translateX(-${currentIndex2 * slideWidth}px)`;
            }

            nextButton.addEventListener('click', () => {
                currentIndex2 = (currentIndex2 + 1) % (slides.length - 2);
                updateTrack();
            });

            prevButton.addEventListener('click', () => {
                currentIndex2 = (currentIndex2 - 1 + (slides.length - 2)) % (slides.length - 2);
                updateTrack();
            });

            updateTrack();
        });

// Suppression des photos
document.querySelectorAll('.delete-photo').forEach(btn => {
    btn.addEventListener('click', function() {
        const photoId = this.dataset.photoId;
        const photoElement = this.closest('.carousel-slide');
        
        if (confirm('Supprimer cette photo ?')) {
            fetch('delete_photo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=delete_photo&photo_id=${photoId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    photoElement.classList.add('fade-out');
                    setTimeout(() => photoElement.remove(), 300);
                    
                    // Mettre à jour l'index du carrousel si nécessaire
                    updateCarouselState();
                } else {
                    alert('Erreur lors de la suppression: ' + (data.error || 'Erreur inconnue'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la suppression');
            });
        }
    });
});

// Suppression des publications
document.querySelectorAll('.delete-poste').forEach(btn => {
    btn.addEventListener('click', function() {
        const postId = this.dataset.postId;
        const postElement = this.closest('.carousel');
        
        if (confirm('Supprimer toute la publication ?')) {
            fetch('delete_photo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=delete_publication&post_id=${postId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    postElement.classList.add('fade-out');
                    setTimeout(() => postElement.remove(), 300);
                    
                    // Mettre à jour le carrousel principal
                    updateCarouselDisplay();
                } else {
                    alert('Erreur lors de la suppression: ' + (data.error || 'Erreur inconnue'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors de la suppression');
            });
        }
    });
});

// Fonction pour mettre à jour l'état du carrousel après suppression
function updateCarouselState() {
    allCarousels.forEach(carousel => {
        const track = carousel.querySelector('.carousel-track');
        const slides = Array.from(track.children);
        if (slides.length === 0) {
            carousel.remove();
        }
    });
    updateCarouselDisplay();
}




        updateCarouselDisplay();
function showUploadModal(publicationId, carouselId) {
            document.getElementById('modal-publication-id').value = publicationId;
            document.getElementById('upload-modal').dataset.carouselId = carouselId;
            document.getElementById('upload-modal').style.display = 'block';
        }

        // Quand on clique sur "Ajout publication"
document.getElementById('btnAjouterPublication').addEventListener('click', function () {
    document.getElementById('modal-publication-id').value = ""; // Nouvelle publication
    document.getElementById('modal-publication-title').value = ""; // Champ titre vide
    document.getElementById('upload-modal').style.display = 'block';
});

// Quand on clique sur "Ajouter photo" pour une publication existante
function showUploadModal(publicationId, carouselId) {
    document.getElementById('modal-publication-id').value = publicationId;
    
    // Cherche le titre dans la page (si besoin)
    const carousel = document.querySelector(`[data-carousel-id="${carouselId}"]`);
    const titreElement = carousel.querySelector('h2');
    const titreTexte = titreElement ? titreElement.textContent.trim() : '';

    document.getElementById('modal-publication-title').value = titreTexte;
    document.getElementById('upload-modal').dataset.carouselId = carouselId;
    document.getElementById('upload-modal').style.display = 'block';
}


    </script>
</body>
</html>
