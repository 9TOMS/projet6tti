<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo</title>
    <style>
        body 
        {
            background-image: url(images/MenuFond.png);
            background-size: cover; 
            background-attachment: fixed; 
        }
        #corps
        {
        display: flex;
  
        }
        .carousel-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            overflow: hidden;
            width: 80%;
            max-width: 900px;
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
        }
        .carousel-track {
            display: flex;
            transition: transform 0.4s ease-in-out;
        }
        .carousel-slide {
            min-width: calc(100% / 3);
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-size: cover;
            background-position: center;
        }
        .carousel-slide img {
            width: 100%;
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
            padding: 10px;
            cursor: pointer;
            border-radius: 50%;
        }
        .carousel-button.prev {
            left: 10px;
        }
        .carousel-button.next {
            right: 10px;
        }
        .switch-carousel-button {
            margin: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php include("tete.php"); ?>
<div id="corps">
<?php include("menu.php"); ?>
<button class="switch-carousel-button prev">&#10094; Carrousel précédent</button>   
    <div class="carousel-wrapper">
        <div class="carousel-container">
            <div class="carousel">
                <h2>Nom 1 + Date 1</h2>
                <div class="carousel-track">
                    <div class="carousel-slide"><img src="https://via.placeholder.com/300x300?text=Carrousel+1+Image+1" alt="Image 1"></div>
                    <div class="carousel-slide"><img src="https://via.placeholder.com/300x300?text=Carrousel+1+Image+2" alt="Image 2"></div>
                    <div class="carousel-slide"><img src="https://via.placeholder.com/300x300?text=Carrousel+1+Image+3" alt="Image 3"></div>
                    <div class="carousel-slide"><img src="https://via.placeholder.com/300x300?text=Carrousel+4+Image+4" alt="Image 4"></div>

                </div>
                <button class="carousel-button prev">&#10094;</button>
                <button class="carousel-button next">&#10095;</button>
            </div>
            <div class="carousel">
                <h2>Nom 2 + Date 2</h2>
                <div class="carousel-track">
                    <div class="carousel-slide"><img src="https://via.placeholder.com/300x300?text=Carrousel+2+Image+1" alt="Image 1"></div>
                    <div class="carousel-slide"><img src="https://via.placeholder.com/300x300?text=Carrousel+2+Image+2" alt="Image 2"></div>
                    <div class="carousel-slide"><img src="https://via.placeholder.com/300x300?text=Carrousel+2+Image+3" alt="Image 3"></div>
                    <div class="carousel-slide"><img src="https://via.placeholder.com/300x300?text=Carrousel+4+Image+4" alt="Image 4"></div>
                </div>
                <button class="carousel-button prev">&#10094;</button>
                <button class="carousel-button next">&#10095;</button>
            </div>
            <div class="carousel">
                <h2>Nom 3 + Date 3</h2>
                <div class="carousel-track">
                    <div class="carousel-slide"><img src="https://via.placeholder.com/300x300?text=Carrousel+3+Image+1" alt="Image 1"></div>
                    <div class="carousel-slide"><img src="https://via.placeholder.com/300x300?text=Carrousel+3+Image+2" alt="Image 2"></div>
                    <div class="carousel-slide"><img src="https://via.placeholder.com/300x300?text=Carrousel+3+Image+3" alt="Image 3"></div>
                    <div class="carousel-slide"><img src="https://via.placeholder.com/300x300?text=Carrousel+4+Image+4" alt="Image 4"></div>
                </div>
                <button class="carousel-button prev">&#10094;</button>
                <button class="carousel-button next">&#10095;</button>
            </div>
            <div class="carousel">
                <h2>Nom 4 + Date 4  </h2>
                <div class="carousel-track">
                    <div class="carousel-slide"><img src="https://via.placeholder.com/300x300?text=Carrousel+4+Image+1" alt="Image 1"></div>
                    <div class="carousel-slide"><img src="https://via.placeholder.com/300x300?text=Carrousel+4+Image+2" alt="Image 2"></div>
                    <div class="carousel-slide"><img src="https://via.placeholder.com/300x300?text=Carrousel+4+Image+3" alt="Image 3"></div>
                    <div class="carousel-slide"><img src="https://via.placeholder.com/300x300?text=Carrousel+4+Image+4" alt="Image 4"></div>
                </div>
                <button class="carousel-button prev">&#10094;</button>
                <button class="carousel-button next">&#10095;</button>
            </div>
        </div>
    </div>
    
    <button class="switch-carousel-button next">Carrousel suivant &#10095;</button>
    </div>
    <?php include("pied_de_page.php"); ?>
    <script>
        const carouselContainer = document.querySelector('.carousel-container');
        const carousels = Array.from(carouselContainer.children);
        const switchPrevButton = document.querySelector('.switch-carousel-button.prev');
        const switchNextButton = document.querySelector('.switch-carousel-button.next');

        let currentCarouselIndex = 0;

        function updateCarouselDisplay() {
            const containerWidth = carousels[0].getBoundingClientRect().width;
            carouselContainer.style.transform = `translateX(-${currentCarouselIndex * containerWidth}px)`;
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

            let currentIndex = 0;

            function updateTrack() {
                const slideWidth = slides[0].getBoundingClientRect().width;
                track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
            }

            nextButton.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % (slides.length - 2);
                updateTrack();
            });

            prevButton.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + (slides.length - 2)) % (slides.length - 2);
                updateTrack();
            });

            updateTrack();
        });

        updateCarouselDisplay();
    </script>
</body>
</html>
