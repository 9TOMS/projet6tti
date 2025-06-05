<?php
session_start();

// Vérification admin (à décommenter et adapter selon votre système d'authentification)
// if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
//     die("Accès refusé");
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_news'])) {
    $bdd = mysqli_connect('localhost', 'root', '', 'crepuscule');
    if (!$bdd) {
        die("Erreur de connexion : " . mysqli_connect_error());
    }

    $id_news = mysqli_real_escape_string($bdd, $_POST['id_news']);
    
    // 1. Récupérer les informations de la news
    $query = "SELECT Photo_News, Media_Type FROM news WHERE Id_News = $id_news";
    $result = mysqli_query($bdd, $query);
    
    if (!$result || mysqli_num_rows($result) === 0) {
        die("News introuvable");
    }
    
    $news = mysqli_fetch_assoc($result);
    
    // 2. Suppression spécifique selon le type de média
    if ($news['Media_Type'] === 'image' && !empty($news['Photo_News'])) {
        // Cas d'une image uploadée - suppression du fichier
        $file_path = $news['Photo_News'];
        
        // Vérifications de sécurité avant suppression
        if (file_exists($file_path) && 
            strpos($file_path, 'uploads/') === 0 && 
            is_file($file_path)) {
            unlink($file_path);
            
            // Optionnel : suppression du dossier parent s'il est vide
            $directory = dirname($file_path);
            if (is_dir($directory) && count(scandir($directory)) == 2) {
                rmdir($directory);
            }
        }
    } 
    // Pour les Google Slides (Media_Type = 'google_slides'), pas de suppression physique nécessaire
    // car c'est juste un lien
    
    // 3. Supprimer les commentaires associés
    $deleteComments = "DELETE FROM commentaires_news WHERE Id_News = $id_news";
    mysqli_query($bdd, $deleteComments);
    
    // 4. Supprimer la news elle-même
    $deleteNews = "DELETE FROM news WHERE Id_News = $id_news";
    if (mysqli_query($bdd, $deleteNews)) {
        header("Location: news.php"); // Redirection vers la page des news
        exit();
    } else {
        echo "Erreur lors de la suppression : " . mysqli_error($bdd);
    }
    
    mysqli_close($bdd);
} else {
    http_response_code(400);
    echo "Requête invalide - méthode non autorisée ou paramètres manquants";
}