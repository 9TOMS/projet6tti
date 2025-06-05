<?php
session_start();
// Vérification admin (décommentez si nécessaire)
// if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
//     die("Accès refusé");
// }

$bdd = mysqli_connect('localhost', 'root', '', 'crepuscule');
if (!$bdd) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

if (!mysqli_set_charset($bdd, "utf8")) {
    echo "Erreur lors du chargement du jeu de caractères utf8 : ", mysqli_error($bdd);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_news'])) {
    $info_news = mysqli_real_escape_string($bdd, trim($_POST['info_news']));
    $media_type = $_POST['media_type'];
    $date_news = date('Y-m-d');
    $media_content = '';
    
    if ($media_type === 'google_slides') {
        $photo_news = trim($_POST['photo_news']);
        $pattern = "/^https:\/\/docs\.google\.com\/presentation\/d\/e\/[a-zA-Z0-9_-]+\/pub\?start=false&loop=false&delayms=3000$/";
        
        if (!preg_match($pattern, $photo_news)) {
            die("❌ Erreur : Lien Google Slides invalide. Soumission rejetée.");
        }
        
        $media_content = $photo_news;
        
    } else if ($media_type === 'image') {
        // Traitement de l'upload d'image
        if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/';
            
            // Créer le dossier s'il n'existe pas
            if (!is_dir($upload_dir)) {
                if (!mkdir($upload_dir, 0755, true)) {
                    die("❌ Erreur : Impossible de créer le dossier d'upload.");
                }
            }
            
            $file_info = pathinfo($_FILES['image_upload']['name']);
            $file_extension = strtolower($file_info['extension']);
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (!in_array($file_extension, $allowed_extensions)) {
                die("❌ Erreur : Format de fichier non autorisé. Formats acceptés : JPG, JPEG, PNG, GIF");
            }
            
            // Vérifier la taille du fichier (5MB max)
            if ($_FILES['image_upload']['size'] > 5 * 1024 * 1024) {
                die("❌ Erreur : L'image est trop volumineuse (max 5MB).");
            }
            
            // Générer un nom unique pour le fichier
            $file_name = uniqid() . '_' . time() . '.' . $file_extension;
            $file_path = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $file_path)) {
                $media_content = $file_path;
                echo "✅ Image uploadée avec succès : " . $file_path . "<br>";
            } else {
                die("❌ Erreur lors de l'upload de l'image.");
            }
        } else {
            $error_messages = [
                UPLOAD_ERR_INI_SIZE => 'Le fichier dépasse la taille maximale autorisée par le serveur.',
                UPLOAD_ERR_FORM_SIZE => 'Le fichier dépasse la taille maximale autorisée par le formulaire.',
                UPLOAD_ERR_PARTIAL => 'Le fichier n\'a été que partiellement uploadé.',
                UPLOAD_ERR_NO_FILE => 'Aucun fichier n\'a été uploadé.',
                UPLOAD_ERR_NO_TMP_DIR => 'Dossier temporaire manquant.',
                UPLOAD_ERR_CANT_WRITE => 'Échec de l\'écriture du fichier sur le disque.',
                UPLOAD_ERR_EXTENSION => 'Upload arrêté par une extension PHP.'
            ];
            
            $error_code = $_FILES['image_upload']['error'] ?? UPLOAD_ERR_NO_FILE;
            $error_message = $error_messages[$error_code] ?? 'Erreur inconnue lors de l\'upload.';
            die("❌ Erreur d'upload : " . $error_message);
        }
    }
    
    // Insertion en base de données avec le type de média
    $query = "INSERT INTO news (Photo_News, Info_News, Date_News, Nombre_Likes, Media_Type) 
              VALUES (?, ?, ?, 0, ?)";
    
    $stmt = mysqli_prepare($bdd, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $media_content, $info_news, $date_news, $media_type);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: news.php"); // redirige vers la page principale après ajout
            exit();
        } else {
            echo "❌ Erreur lors de l'ajout en base : " . mysqli_error($bdd);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "❌ Erreur de préparation de la requête : " . mysqli_error($bdd);
    }
}

mysqli_close($bdd);
?>