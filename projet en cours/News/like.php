<?php
session_start(); // Récupération utilisateur connecté
$bdd = mysqli_connect('localhost', 'root', '', 'crepuscule');

header('Content-Type: application/json');

if (!$bdd) {
    echo json_encode(['success' => false, 'error' => 'Connexion échouée']);
    exit;
}
// Vérifie si l'utilisateur est connecté
//if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id_membre'])) {
    $id_news = intval($_POST['id_news']);
    $id_membre = 2;//intval($_SESSION['id_membre']);

    // Vérifie si déjà liké
    $checkQuery = "SELECT * FROM likes_news WHERE id_news = $id_news AND id_membre = $id_membre";
    $checkResult = mysqli_query($bdd, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Retirer le like
        mysqli_query($bdd, "DELETE FROM likes_news WHERE id_news = $id_news AND id_membre = $id_membre");
        mysqli_query($bdd, "UPDATE news SET Nombre_Likes = GREATEST(Nombre_Likes - 1, 0) WHERE Id_News = $id_news");
        $action = 'unliked';
    } else {
        // Ajouter le like
        mysqli_query($bdd, "INSERT INTO likes_news (id_news, id_membre) VALUES ($id_news, $id_membre)");
        mysqli_query($bdd, "UPDATE news SET Nombre_Likes = Nombre_Likes + 1 WHERE Id_News = $id_news");
        $action = 'liked';
    }

    // Récupère le nombre de likes à jour
    $res = mysqli_query($bdd, "SELECT Nombre_Likes FROM news WHERE Id_News = $id_news");
    $data = mysqli_fetch_assoc($res);

    echo json_encode([
        'success' => true,
        'likes' => $data['Nombre_Likes'],
        'action' => $action
    ]);
//} else {
//    echo json_encode(['success' => false, 'error' => 'Utilisateur non connecté']);
//}
?>
