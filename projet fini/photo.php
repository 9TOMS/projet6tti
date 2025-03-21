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
            width: calc(100vw - 334px);
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
            right: 10px;
        }

        .switch-carousel-button {
            position:relative;
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
    </style>
</head>

<body>
    <?php include("entete.php"); ?>
    <div class="page">
        <?php include("menu.php"); ?>
        <button class="switch-carousel-button prev">&#10094;</button>
        <div class="carousel-wrapper">
            <div class="carousel-container">
                <?php for ($i = 1; $i <= 4; $i++) { ?>
                    <div class="carousel">
                        <h2>Publication <?php echo $i; ?></h2>
                        <div class="carousel-track">
                            <?php for ($j = 1; $j <= 10; $j++) { ?>
                                <div class="carousel-slide"><img
                                        src="images/test.jpg"
                                        alt="Image <?php echo $j; ?>"></div>
                            <?php } ?>
                        </div>
                        <button class="carousel-button prev">&#10094;</button>
                        <button class="carousel-button next">&#10095;</button>
                    </div>
                <?php } ?>
            </div>
        </div>

        <button class="switch-carousel-button next">&#10095;</button>
    </div>
    <?php include("pied_de_page.php"); ?>
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

        updateCarouselDisplay();
    </script>
</body>

</html>