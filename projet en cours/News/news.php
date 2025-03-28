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
                    $query = "SELECT COUNT(*) as total FROM news";
                    $result = mysqli_query($bdd, $query);
                    $row = mysqli_fetch_assoc($result);
                    $nombreTotalNews = $row['total'];
                    ?>
                    <div id="myElement" data-variable="<?php echo $nombreTotalNews; ?>"></div>
                    <?php
                    for ($i = 1; $i <= $nombreTotalNews; $i++) {
                        $query = "SELECT Id_News, Photo_News FROM news ORDER BY Id_News";
                        $result = mysqli_query($bdd, $query);
                        // Parcourir toutes les news disponibles
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['Id_News'];
                            $imageSrc = $row['Photo_News'];

                            echo '<div class="news-item" id="news-' . $id . '">';
                            include("includenews.php");
                            echo '</div>';
                        }
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
