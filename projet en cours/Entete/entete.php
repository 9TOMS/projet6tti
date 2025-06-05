<?php
$connexion = mysqli_connect('localhost', 'root', '', 'crepuscule');

if (!mysqli_set_charset($connexion, "utf8")) {
    echo "Erreur lors du chargement du jeu de caractères utf8 : ", mysqli_error($connexion);
    exit();
}

        define('PREFIX_SALT', 'ççaaaa111222333');
        define('SUFFIX_SALT', 'ççbbbb444555666');
        

        

                


                if (isset($_POST['togglebutton1'])) {
                    $nom = mysqli_real_escape_string($connexion, $_POST['name']);
                    $prenom = mysqli_real_escape_string($connexion, $_POST['surname']);
                    $age = mysqli_real_escape_string($connexion, $_POST['Age']);
                    $parentname = mysqli_real_escape_string($connexion, $_POST['parentname']);
                    $parentsurname = mysqli_real_escape_string($connexion, $_POST['parentsurname']);
                    $Condition = mysqli_real_escape_string($connexion, $_POST['Condition']);
                    $entenduparler = mysqli_real_escape_string($connexion, $_POST['entenduparler']);
                    $mail = mysqli_real_escape_string($connexion, $_POST['email']);
                    $phone = mysqli_real_escape_string($connexion, $_POST['phone']);
                    $mdp = mysqli_real_escape_string($connexion, $_POST['password']);
                    $verifmdp = mysqli_real_escape_string($connexion, $_POST['passwordverif']); 
                    $sexe = mysqli_real_escape_string($connexion, $_POST['sexe']);
                
                    if ($mdp == $verifmdp) {
                        $hashSecure = password_hash(PREFIX_SALT . $mdp . SUFFIX_SALT, PASSWORD_DEFAULT); 
                        $insert_query = "INSERT INTO `membre`(`ID_Membre`, `Enfant`, `Nom_Membre`, `Prenom_Membre`, `Anniversaire_Membre`, `Nom_parent_Membre`, `Prenom_parent_Membre`, `Telephone_Membre`, `Mail_Membre`, `Comment_decouvert`, `Condition_Membre`, `Mot_de_passe_Membre`, `Affilie_Membre`, `admin`) 
                        VALUES (NULL, TRUE, '$nom', '$prenom', '$age', '$parentname', '$parentsurname', '$phone', '$mail', '$entenduparler', '$Condition', '$hashSecure', FALSE, FALSE)";
                        
                        $result = mysqli_query($connexion, $insert_query);
                        if ($result) {
                            echo "Insertion réussie.";
                        } else {
                            echo "Erreur d'insertion : " . mysqli_error($connexion);
                        }

                        session_start();
                        setcookie( 'mail', $mail, time() + 90*24*3600, null, false, true);
                        setcookie( 'mdp', $hashSecure, time() + 90*24*3600, null, false, true);
                    } else {
                        echo "Les mots de passe ne correspondent pas.";
                    }
                }
                if (isset($_POST['togglebutton2'])) {
                    $nom = mysqli_real_escape_string($connexion, $_POST['name']);
                    $prenom = mysqli_real_escape_string($connexion, $_POST['surname']);
                    $age = mysqli_real_escape_string($connexion, $_POST['Age']);
                    $Condition = mysqli_real_escape_string($connexion, $_POST['Condition']);
                    $entenduparler = mysqli_real_escape_string($connexion, $_POST['entenduparler']);
                    $mail = mysqli_real_escape_string($connexion, $_POST['email']);
                    $phone = mysqli_real_escape_string($connexion, $_POST['phone']);
                    $mdp = mysqli_real_escape_string($connexion, $_POST['password']);
                    $verifmdp = mysqli_real_escape_string($connexion, $_POST['passwordverif']); 
                    $sexe = mysqli_real_escape_string($connexion, $_POST['sexe']);
                
                    if ($mdp == $verifmdp) {
                        $hashSecure = password_hash(PREFIX_SALT . $mdp . SUFFIX_SALT, PASSWORD_DEFAULT); 
                        $insert_query = "INSERT INTO `membre`(`ID_Membre`, `Enfant`, `Nom_Membre`, `Prenom_Membre`, `Anniversaire_Membre`, `Nom_parent_Membre`, `Prenom_parent_Membre`, `Telephone_Membre`, `Mail_Membre`, `Comment_decouvert`, `Condition_Membre`, `Mot_de_passe_Membre`, `Affilie_Membre`, `admin`) 
                        VALUES (NULL, TRUE, '$nom', '$prenom', '$age', NULL, NULL, '$phone', '$mail', '$entenduparler', '$Condition', '$hashSecure', FALSE, FALSE)";
                        
                        $result = mysqli_query($connexion, $insert_query);
                        if ($result) {
                            echo "Insertion réussie.";
                        } else {
                            echo "Erreur d'insertion : " . mysqli_error($connexion);
                        }

                        session_start();
                        setcookie( 'mail', $mail, time() + 90*24*3600, null, false, true);
                        setcookie( 'mdp', $hashSecure, time() + 90*24*3600, null, false, true);
                    } else {
                        echo "Les mots de passe ne correspondent pas.";
                    }
                }

                
                    

                                   
                if (isset($_POST['togglebutton3'])) {
                    session_start(); // Toujours au début avant toute sortie

                    // Sécurisation des entrées
                    $mail = mysqli_real_escape_string($connexion, $_POST['email']);
                    $mdp = mysqli_real_escape_string($connexion, $_POST['password']);
                    $mdp_salte = PREFIX_SALT . $mdp . SUFFIX_SALT;

                    // Requête SQL combinée
                    $sql = "SELECT `Mot_de_passe_Membre`, `Mail_Membre`, `admin` FROM `membre` WHERE `Mail_Membre` = '$mail'";

                    $result = mysqli_query($connexion, $sql);

                    if ($result && mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_assoc($result);
                        $hashpassword = $row['Mot_de_passe_Membre'];
                        $mailv = $row['Mail_Membre'];
                        $isadmin = $row['admin'];

                        // Vérification du mot de passe
                        if (password_verify($mdp_salte, $hashpassword)) {
                            if ($isadmin == '1') {
                                echo "Connexion admin réussie. " . htmlspecialchars($mail);
                                $connecte = true;
                                $_SESSION['admin'] = $mail;

                                setcookie('admin', $mail, time() + 90*24*3600, '/', '', false, true);

                                // Tu peux stocker $isadmin aussi si nécessaire :
                                // $_SESSION['admin'] = $isadmin;
                            }else if ($isadmin == '0'){
                                echo "Connexion réussie. " . htmlspecialchars($isadmin);
                                $connecte = true;
                                $_SESSION['mail'] = $mail;

                                setcookie('mail', $mail, time() + 90*24*3600, '/', '', false, true);

                                // Tu peux stocker $isadmin aussi si nécessaire :
                                // $_SESSION['admin'] = $isadmin;
                            }
                            
                        } else {
                            echo "Erreur de connexion : mot de passe incorrect.";
                            $connecte = false;
                        }
                    } else {
                        echo "Erreur de connexion : utilisateur non trouvé.";
                        $connecte = false;
                    }



                    
                }

                

    


        

            
            
         
            

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="entete.css" rel="stylesheet">
    <script src="entete.js"></script>
</head>
<body>
<div id ="tete">
    <div id ="logo">
        <img id ="logo1" src="images/logo.png">
    </div>
    <div id = "centre">
        <div id = "nom">
            <h1>Crépuscule</h1>
        </div>
         <div id = "citation">
            <h2>
            <span class="survole">Respect,
                    <span class="moment-survole">Respect des autres membres du club, des moniteurs et responsables, des consignes, du matériel et des infrastructures mais aussi et surtout des chevaux.</span>
                </span>
                <span class="survole">Confiance,
                    <span class="moment-survole">Oser essayer augmenter sa confiance en soi. Le cheval vous fera alors confiance car il est comme votre reflet dans un miroir.</span>
                </span>
                <span class="survole">Solidarité,
                    <span class="moment-survole">Entraide partage échange de ses compétences et savoirs pour aider les autres.</span>
                </span>
                <span class="survole">Sécurité,
                    <span class="moment-survole">Prendre du plaisir dans les activités tout en respectant.</span>
                </span>
            </h2>
        </div>
    </div>
    <div id = "inscription">
        <img alt="Cliquez ici" onclick="openPopup()" id = "inscription1" src="images/profil.png"/>
        
    </div>  
    <div id="popup" class="popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h2 id="form-title">Que voulez-vous faire ?</h2>
        <form id="popup-form" method="post">
            <div id="info-kids-fields" >
                    
            </div>
            <div id="info-parents-fields" >     
            </div>

            <div id="info-person-fields" >
                    
            </div>


            <div id="info-fields" >
                
            </div>

            <div id="password-fields" >
            </div>

            <button name="" class="boutonpop" type="submit" id="toggle-button-1" onclick="inscriptionenfant()">inscrire un enfant</button> 
            <button name="" class="boutonpop" type="submit" id="toggle-button-2" onclick="inscription()">s'inscrire</button>    
            <button name="" class="boutonpop" type="submit" id="toggle-button-3" onclick="connexion()">se connecter</button>
            
        </form>
    </div>
</div>
    </div> 











