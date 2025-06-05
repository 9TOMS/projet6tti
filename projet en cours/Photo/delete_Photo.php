<?php
require_once("connexion_bd.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        try {
            if ($_POST['action'] === 'delete_photo' && isset($_POST['photo_id'])) {
                $photoId = $_POST['photo_id'];
                $stmt = $conn->prepare("DELETE FROM photo WHERE Id_Photo = ?");
                $stmt->bind_param("i", $photoId);
                $stmt->execute();
                
                echo json_encode(['success' => true]);
                exit;
            }
            elseif ($_POST['action'] === 'delete_publication' && isset($_POST['post_id'])) {
                $postId = $_POST['post_id'];
                $stmt = $conn->prepare("DELETE FROM photo WHERE id_parent = ?");
                $stmt->bind_param("i", $postId);
                $stmt->execute();
                 $stmt = $conn->prepare("DELETE FROM parent_photo WHERE id_parent = ?");
                $stmt->bind_param("i", $postId);
                $stmt->execute();
                
                echo json_encode(['success' => true]);
                exit;
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit;
        }
    }
}

echo json_encode(['success' => false, 'error' => 'Requête invalide']);
?>
