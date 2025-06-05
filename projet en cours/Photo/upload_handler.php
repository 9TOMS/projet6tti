<?php
header('Content-Type: application/json');
$response = ['success' => false];

try {
    require_once("connexion_bd.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photos'])) {
        $publication_id = isset($_POST['publication_id']) ? intval($_POST['publication_id']) : 0;
        $titre = isset($_POST['publication_title']) ? trim($_POST['publication_title']) : '';
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

      // Cas 1 : Créer une nouvelle publication si publication_id = 0
if ($publication_id === 0 && !empty($titre)) {
    // Récupérer l'ID max existant
    $result = $conn->query("SELECT MAX(id_parent) AS max_id FROM parent_photo");
    $row = $result->fetch_assoc();
    $new_id = $row['max_id'] + 1;

    // Insérer la nouvelle publication avec l'ID manuellement
    $stmt = $conn->prepare("INSERT INTO parent_photo (id_parent, parent_nom) VALUES ( ? , ?)");
    $stmt->bind_param("is", $new_id, $titre);
   // INSERT INTO `parent_photo`(`id_parent`, `parent_nom`) VALUES (4,'Velo')
    if (!$stmt->execute()) {
        echo "Erreur SQL : " . $stmt->error;
    }

    // Utiliser ce nouvel ID pour la suite
    $publication_id = $new_id;
}

        // Cas 2 : Modifier le titre si l'ID existe et un titre est fourni
        if ($publication_id !== 0 && !empty($titre)) {
            $stmt = $conn->prepare("UPDATE parent_photo SET parent_nom = ? WHERE id_parent = ?");
            $stmt->bind_param("si", $titre, $publication_id);
            $stmt->execute();
        }

        // Enregistrer les images dans la table `photo`
        foreach ($_FILES['photos']['tmp_name'] as $index => $tmpName) {
            if (empty($tmpName)) continue;

            $fileType = mime_content_type($tmpName);
            if (!in_array($fileType, $allowedTypes)) {
                $response['error'] = 'Type de fichier non autorisé: ' . $fileType;
                continue;
            }

            $fileName = uniqid() . '_' . basename($_FILES['photos']['name'][$index]);
            $targetPath = 'images/' . $fileName;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $stmt = $conn->prepare("INSERT INTO photo (id_parent, photo_photo) VALUES (?, ?)");
                $stmt->bind_param("is", $publication_id, $targetPath);
                $stmt->execute();
            }
        }

        $response['success'] = true;
        $response['new_publication_id'] = $publication_id;
    } else {
        $response['error'] = 'Données manquantes';
    }
} catch (Exception $e) {
    $response['error'] = 'Erreur: ' . $e->getMessage();
}

echo json_encode($response);
?>