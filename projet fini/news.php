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
            width: 85%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .carousel {
            position: relative;
            width: 90%;
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
            height: calc(100vh - 235px);
        }

        .carousel-arrow {
            position: absolute;
            top: 45%;
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
    </style>
</head>

<body>
    <?php include("entete.php"); ?>

    <div class="page">
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
</body>

</html>