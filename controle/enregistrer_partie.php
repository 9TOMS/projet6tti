<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $nbrCoups = intval($_POST['coups']);
    $temps = $_POST['temps']; 

    $host_name = 'localhost';
    $database = 'jeunombre';
    $user_name = 'root';      
    $password = '';           

    $conn = new mysqli($host_name, $user_name, $password, $database);
    if ($conn->connect_error) {
        die("Erreur de connexion: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO stat (Pseudo, NbrCoups, Temps) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $pseudo, $nbrCoups, $temps); 
    $stmt->execute();

    echo "Données enregistrées avec succès.";
    $stmt->close();
    $conn->close();
}
?>
