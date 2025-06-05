<?php
header('Content-Type: application/json');

$bdd = mysqli_connect('localhost', 'root', '', 'crepuscule');

if (!$bdd) {
    die(json_encode(['success' => false, 'error' => 'Connection failed: ' . mysqli_connect_error()]));
}

if (!mysqli_set_charset($bdd, "utf8")) {
    die(json_encode(['success' => false, 'error' => 'Erreur charset: ' . mysqli_error($bdd)]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_news = mysqli_real_escape_string($bdd, $_POST['id_news']);
    $id_membre = mysqli_real_escape_string($bdd, $_POST['id_membre']);
    $contenu_commentaire = mysqli_real_escape_string($bdd, $_POST['commentaire']);

    if (!empty($contenu_commentaire)) {
        // Insérer le commentaire
        $insertQuery = "INSERT INTO commentaires_news (Id_News, Id_Membre, Contenu_Commentaire)
                        VALUES ('$id_news', '$id_membre', '$contenu_commentaire')";
        
        if (mysqli_query($bdd, $insertQuery)) {
            // Récupérer les infos du membre et la date pour la réponse
            $query = "SELECT m.Nom_Membre, c.Date_Commentaire 
                      FROM commentaires_news c
                      JOIN membre m ON c.Id_Membre = m.ID_Membre
                      WHERE c.Id_Commentaire = LAST_INSERT_ID()";
            $result = mysqli_query($bdd, $query);
            $commentData = mysqli_fetch_assoc($result);
            
            echo json_encode([
                'success' => true,
                'nom_membre' => $commentData['Nom_Membre'],
                'date_commentaire' => $commentData['Date_Commentaire'],
                'contenu' => $contenu_commentaire
            ]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($bdd)]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Le commentaire ne peut pas être vide']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée']);
}
?>