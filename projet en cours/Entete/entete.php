<?php
ob_start();
$connexion = mysqli_connect('localhost', 'root', '', 'crepuscule');

if (!mysqli_set_charset($connexion, "utf8")) {
    echo "Erreur lors du chargement du jeu de caractères utf8 : ", mysqli_error($connexion);
    exit();
}

      
            //session_start();
            ob_start(); // optionnel, utile pour éviter les erreurs d'envoi prématuré

        define('PREFIX_SALT', 'ççaaaa111222333');
        define('SUFFIX_SALT', 'ççbbbb444555666');

        $connecte = false;
        

        if (isset($_COOKIE['mail']) && isset($_COOKIE['mdp']))  {
            $mdp = $_COOKIE['mdp'];
            $mailuti = $_COOKIE['mail'];
            $mdp_salte = PREFIX_SALT . $_COOKIE['adminmdp'] . SUFFIX_SALT;
                    // Requête SQL combinée
                    $sql = "SELECT `Mot_de_passe_Membre`, `Mail_Membre`, `administrateur` FROM `membre` WHERE `Mail_Membre` = '$mailuti'";

                    $result = mysqli_query($connexion, $sql);

                    if ($result && mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_assoc($result);
                        $hashpassword = $row['Mot_de_passe_Membre'];
                        $mailv = $row['Mail_Membre'];
                        $isadmin = $row['administrateur'];

                        // Vérification du mot de passe
                        if (password_verify($mdp_salte, $hashpassword)) {
                            
                                
                                $connecte = true;
                                $_SESSION['utilisateur'] = $mail;
                                echo "Connexion réussie. " . htmlspecialchars($mail);
                                 $administrateur = false;

                                // Tu peux stocker $isadmin aussi si nécessaire :
                                // $_SESSION['admin'] = $isadmin;
                            }
                            
                        } 
                    } 

                if (isset($_COOKIE['administrateur']) && isset($_COOKIE['adminmdp']))  {
                    $mdp_salte = PREFIX_SALT . $_COOKIE['adminmdp'] . SUFFIX_SALT;
                    $mailuti = $_COOKIE['administrateur'];

                            // Requête SQL combinée
                            $sql = "SELECT `Mot_de_passe_Membre`, `Mail_Membre`, `administrateur` FROM `membre` WHERE `Mail_Membre` = '$mailuti'";

                            $result = mysqli_query($connexion, $sql);

                            if ($result && mysqli_num_rows($result) == 1) {
                                $row = mysqli_fetch_assoc($result);
                                $hashpassword = $row['Mot_de_passe_Membre'];
                                $mailv = $row['Mail_Membre'];
                                $isadmin = $row['administrateur'];

                                // Vérification du mot de passe
                                if (password_verify($mdp_salte, $hashpassword)) {
                                    
                                        
                                        $connecte = true;
                                        $_SESSION['utilisateur'] = $mail;
                                        echo "Connexion admin réussie. " . htmlspecialchars($mail);
                                        $administrateur = true;

                                        // Tu peux stocker $isadmin aussi si nécessaire :
                                        // $_SESSION['admin'] = $isadmin;
                                    }
                                    
                                } 
                            } 



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
                        $insert_query = "INSERT INTO `membre`(`ID_Membre`, `Enfant`, `Nom_Membre`, `Prenom_Membre`, `Anniversaire_Membre`, `Nom_parent_Membre`, `Prenom_parent_Membre`, `Telephone_Membre`, `Mail_Membre`, `Comment_decouvert`, `Condition_Membre`, `Mot_de_passe_Membre`, `Affilie_Membre`, `administrateur`) 
                        VALUES (NULL, TRUE, '$nom', '$prenom', '$age', '$parentname', '$parentsurname', '$phone', '$mail', '$entenduparler', '$Condition', '$hashSecure', FALSE, FALSE)";
                        
                        $result = mysqli_query($connexion, $insert_query);
                        if ($result) {
                            echo "Insertion réussie.";
                        } else {
                            echo "Erreur d'insertion : " . mysqli_error($connexion);
                        }

                         $administrateur = false;

                        setcookie('mailuser', $mail, time() + 90*24*3600, '/', '', false, true);
                                setcookie('mdpuser', $mdp, time() + 90*24*3600, '/', '', false, true);
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
                        $insert_query = "INSERT INTO `membre`(`ID_Membre`, `Enfant`, `Nom_Membre`, `Prenom_Membre`, `Anniversaire_Membre`, `Nom_parent_Membre`, `Prenom_parent_Membre`, `Telephone_Membre`, `Mail_Membre`, `Comment_decouvert`, `Condition_Membre`, `Mot_de_passe_Membre`, `Affilie_Membre`, `administrateur`) 
                        VALUES (NULL, TRUE, '$nom', '$prenom', '$age', NULL, NULL, '$phone', '$mail', '$entenduparler', '$Condition', '$hashSecure', FALSE, FALSE)";
                        
                        $result = mysqli_query($connexion, $insert_query);
                        if ($result) {
                            echo "Insertion réussie.";
                        } else {
                            echo "Erreur d'insertion : " . mysqli_error($connexion);
                        }

                        
                            setcookie('mailuser', $mail, time() + 90*24*3600, '/', '', false, true);
                                setcookie('mdpuser', $mdp, time() + 90*24*3600, '/', '', false, true);
                             $administrateur = false;

                            echo "Insertion réussie."; // DOIT venir après les setcookie

                    } else {
                        echo "Les mots de passe ne correspondent pas.";
                    }
                }

                
                    

                                   
                if (isset($_POST['togglebutton3'])) {
                    

                    // Sécurisation des entrées
                    $mail = mysqli_real_escape_string($connexion, $_POST['email']);
                    $mdp = mysqli_real_escape_string($connexion, $_POST['password']);
                    $mdp_salte = PREFIX_SALT . $mdp . SUFFIX_SALT;

                    // Requête SQL combinée
                    $sql = "SELECT `Mot_de_passe_Membre`, `Mail_Membre`, `administrateur` FROM `membre` WHERE `Mail_Membre` = '$mail'";

                    $result = mysqli_query($connexion, $sql);

                    if ($result && mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_assoc($result);
                        $hashpassword = $row['Mot_de_passe_Membre'];
                        $mailv = $row['Mail_Membre'];
                        $isadmin = $row['administrateur'];

                        // Vérification du mot de passe
                        if (password_verify($mdp_salte, $hashpassword)) {
                            if ($isadmin == TRUE) {
                               
                                $connecte = true;
                                $_SESSION['administrateur'] = $mail;
                                 $administrateur = true;

                                
                                setcookie('administrateur', $mail, time() + 90*24*3600, '/', '', false, true);
                                setcookie('adminmdp', $mdp, time() + 90*24*3600, '/', '', false, true);
                                echo "Connexion admin réussie. " . htmlspecialchars($mail);
                                // Tu peux stocker $isadmin aussi si nécessaire :
                                // $_SESSION['admin'] = $isadmin;
                            }else if ($isadmin == FALSE){
                                
                                $connecte = true;
                                $admin = false;
                                $_SESSION['utilisateur'] = $mail;

                                setcookie('mailuser', $mail, time() + 90*24*3600, '/', '', false, true);
                                setcookie('mdpuser', $mdp, time() + 90*24*3600, '/', '', false, true);
                                echo "Connexion réussie. " . htmlspecialchars($isadmin);
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
<style>
        /* Styles de base */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        
        #tete {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #e7e7e7;
        }
        
        #logo img {
            height: 80px;
        }
        
        #centre {
            text-align: center;
        }
        
        #nom h1 {
            margin: 0;
            color: #333;
        }
        
        #citation h2 {
            font-size: 1rem;
            font-weight: normal;
            color: #666;
        }
        
        .survole {
            position: relative;
            cursor: pointer;
            margin: 0 5px;
        }
        
        .moment-survole {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 10px;
            z-index: 100;
            width: 200px;
            left: 50%;
            transform: translateX(-50%);
            top: 100%;
        }
        
        .survole:hover .moment-survole {
            display: block;
        }
        
        #inscription img {
            height: 40px;
            cursor: pointer;
        }
        
        /* Popup styles */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .popup-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .close-btn {
            float: right;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        /* Form styles */
        #popup-form {
            display: grid;
            gap: 15px;
        }
        
        #popup-form label {
            display: block;
            margin-bottom: 5px;
        }
        
        #popup-form input[type="text"],
        #popup-form input[type="email"],
        #popup-form input[type="tel"],
        #popup-form input[type="date"],
        #popup-form input[type="password"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        
        .boutonpop {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .boutonpop:hover {
            background-color: #45a049;
        }
        
        /* Grid layout for form sections */
        #info-kids-fields,
        #info-parents-fields,
        #info-person-fields,
        #password-fields {
            display: none;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        #info-fields {
            display: grid;
            gap: 15px;
        }
        
        /* Messages d'erreur/succès */
        .error {
            color: red;
            margin: 10px 0;
        }
        
        .success {
            color: green;
            margin: 10px 0;
        }
    </style>
<div id="entete">
    <link rel="stylesheet" href="main.css">
    <script defer src="java.js"></script>
    <div id="logo_entete">
        <input class="menu2" id="image1" type="button" value=":" onclick="openNav()">
        <a href="index.php"><img id="img_logo" src="images/logo.png"></a>
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="index.php">Accueil </a>
            <a href="news.php">News </a>
            <a href="photo.php">Photos </a>
            <a href="contact.php">Contact </a>
            <a href="agenda.php">Agenda </a>
            <a href="tarif.php">Tarif </a>
        </div>
    </div>
    <div id="titre_entete">
        <div id="titre_nom">Crépuscule</div>
        <div id="titre_citation">
            <span class="info_bulle_entete">Respect,
                <span class="info_bulle_entete-text">Respect des autres membres du club, des moniteurs et responsables,
                    des consignes, du matériel et des infrastructures mais aussi et surtout des chevaux.</span>
            </span>
            <span class="info_bulle_entete">Confiance,
                <span class="info_bulle_entete-text">Oser essayer augmenter sa confiance en soi. Le cheval vous fera
                    alors confiance car il est comme votre reflet dans un miroir.</span>
            </span>
            <span class="info_bulle_entete">Solidarité,
                <span class="info_bulle_entete-text">Entraide partage échange de ses compétences et savoirs pour aider
                    les autres.</span>
            </span>
            <span class="info_bulle_entete">Sécurité
                <span class="info_bulle_entete-text">Prendre du plaisir dans les activités tout en respectant.</span>
            </span>
        </div>
    </div>
    <div id="inscription_entete">
        <img alt="Cliquez ici" onclick="openPopup()" id="img_inscription" src="images/profil.png" />
    </div>
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <h2 id="form-title">Que voulez-vous faire ?</h2>
            <form id="popup-form" method="post">
                <div id="info-kids-fields"></div>
                <div id="info-parents-fields"></div>
                <div id="info-person-fields"></div>
                <div id="info-fields"></div>
                <div id="password-fields"></div>
                 <div id="envoyer-fields"></div>

                <button name="" class="boutonpop" type="submit" id="toggle-button-1" onclick="inscriptionenfant()">Inscrire un enfant</button> 
                <button name="" class="boutonpop" type="submit" id="toggle-button-2" onclick="inscription()">Inscription</button>    
                <button name="" class="boutonpop" type="submit" id="toggle-button-3" onclick="connexion()">Se connecter</button>
                <input type="hidden" name="form-type" id="form-type" value="">
            </form>
        </div>
    </div>
</div>

    <script>
        // Fonction pour ouvrir le pop-up
        function openPopup() {
            document.getElementById('popup').style.display = 'flex';
        }

        // Fonction pour fermer le pop-up
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
        }

        // Fermer le pop-up en cliquant à l'extérieur
        window.addEventListener('click', (e) => {
            const popup = document.getElementById('popup');
            if (e.target === popup) {
                popup.style.display = 'none';
            }
        });

        // Fonction d'inscription enfant
        function inscriptionenfant() {
            document.getElementById('form-title').innerText = 'Inscription enfant';
            
            document.getElementById('info-kids-fields').style.display = 'grid';
            document.getElementById('info-parents-fields').style.display = 'grid';
            document.getElementById('info-person-fields').style.display = 'none';
            
            document.getElementById('info-kids-fields').innerHTML = `
                <div>
                    <label for="name">Nom de l'enfant :</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="surname">Prénom de l'enfant :</label>
                    <input type="text" id="surname" name="surname" required>
                </div>
                <div>
                    <label for="Age">Date de naissance :</label>
                    <input type="date" id="Age" name="Age" required>    
                </div>
                <div>
                    <label for="sexe">Sexe (M/F) :</label>
                    <input type="text" id="sexe" name="sexe" maxlength="1" required>  
                </div>
            `;

            document.getElementById('info-parents-fields').innerHTML = `
                <div>
                    <label for="parentname">Nom du parent :</label>
                    <input type="text" id="parentname" name="parentname" required>
                </div>
                <div>
                    <label for="parentsurname">Prénom du parent :</label>
                    <input type="text" id="parentsurname" name="parentsurname" required>
                </div>
                <div>
                    <label for="phone">Téléphone :</label>
                    <input type="tel" id="phone" name="phone" required>  
                </div>
                <div>
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required> 
                </div>
            `;

            document.getElementById('info-fields').innerHTML = `
                <label for="entenduparler">Comment avez-vous entendu parler de nous ?</label>
                <input type="text" id="entenduparler" name="entenduparler" required>
                <label for="Condition">Condition médicale (allergies, etc.) :</label>
                <input type="text" id="Condition" name="Condition" required>
            `;

            document.getElementById('password-fields').style.display = 'grid';
            document.getElementById('password-fields').innerHTML = `
                <div>
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required> 
                </div>
                <div>
                    <label for="passwordverif">Confirmation :</label>
                    <input type="password" id="passwordverif" name="passwordverif" required> 
                </div>
            `;
            
            document.getElementById('envoyer-fields').innerHTML = `
            <button type="submit" name="submit">Envoyer</button>`;
            

            // Mise à jour des boutons
            document.getElementById('toggle-button-1').setAttribute('name', 'togglebutton1');
            document.getElementById('toggle-button-1').removeAttribute('onclick');
            
            document.getElementById('toggle-button-2').removeAttribute('name');
            document.getElementById('toggle-button-2').setAttribute('onclick', 'inscription()');
            
            document.getElementById('toggle-button-3').removeAttribute('name');
            document.getElementById('toggle-button-3').setAttribute('onclick', 'connexion()');
        }

        // Fonction d'inscription adulte
        function inscription() {
            document.getElementById('form-title').innerText = 'Inscription adulte';
            
            document.getElementById('info-kids-fields').style.display = 'none';
            document.getElementById('info-parents-fields').style.display = 'none';
            document.getElementById('info-person-fields').style.display = 'grid';
            
            document.getElementById('info-person-fields').innerHTML = `
                <div>
                    <label for="name">Nom :</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="surname">Prénom :</label>
                    <input type="text" id="surname" name="surname" required>
                </div>
                <div>
                    <label for="Age">Date de naissance :</label>
                    <input type="date" id="Age" name="Age" required>    
                </div>
                <div>
                    <label for="sexe">Sexe (M/F) :</label>
                    <input type="text" id="sexe" name="sexe" maxlength="1" required>  
                </div>
                <div>
                    <label for="phone">Téléphone :</label>
                    <input type="tel" id="phone" name="phone" required>  
                </div>
                <div>
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required> 
                </div>
            `;

            document.getElementById('info-fields').innerHTML = `
                <label for="entenduparler">Comment avez-vous entendu parler de nous ?</label>
                <input type="text" id="entenduparler" name="entenduparler" required>
                <label for="Condition">Condition médicale (allergies, etc.) :</label>
                <input type="text" id="Condition" name="Condition" required>
            `;

            document.getElementById('password-fields').style.display = 'grid';
            document.getElementById('password-fields').innerHTML = `
                <div>
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required> 
                </div>
                <div>
                    <label for="passwordverif">Confirmation :</label>
                    <input type="password" id="passwordverif" name="passwordverif" required> 
                </div>
            `;

            // Mise à jour des boutons
            document.getElementById('toggle-button-2').setAttribute('name', 'togglebutton2');
            document.getElementById('toggle-button-2').removeAttribute('onclick');
            
            document.getElementById('toggle-button-1').removeAttribute('name');
            document.getElementById('toggle-button-1').setAttribute('onclick', 'inscriptionenfant()');
            
            document.getElementById('toggle-button-3').removeAttribute('name');
            document.getElementById('toggle-button-3').setAttribute('onclick', 'connexion()');
        }

        // Fonction de connexion
        function connexion() {
            document.getElementById('form-title').innerText = 'Connexion';
            
            document.getElementById('info-kids-fields').style.display = 'none';
            document.getElementById('info-parents-fields').style.display = 'none';
            document.getElementById('info-person-fields').style.display = 'none';
            
            document.getElementById('info-fields').innerHTML = `
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            `;

            document.getElementById('password-fields').style.display = 'block';
            document.getElementById('password-fields').innerHTML = `
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            `;

            // Mise à jour des boutons
            document.getElementById('toggle-button-3').setAttribute('name', 'togglebutton3');
            document.getElementById('toggle-button-3').removeAttribute('onclick');
            
            document.getElementById('toggle-button-1').removeAttribute('name');
            document.getElementById('toggle-button-1').setAttribute('onclick', 'inscriptionenfant()');
            
            document.getElementById('toggle-button-2').removeAttribute('name');
            document.getElementById('toggle-button-2').setAttribute('onclick', 'inscription()');
        }

        // Fonction pour ouvrir le pop-up
function openPopup() {
    const popup = document.getElementById('popup');
    popup.style.display = 'flex'; // Affiche le pop-up
}

// Fonction pour fermer le pop-up
function closePopup() {
    const popup = document.getElementById('popup');
    popup.style.display = 'none'; // Cache le pop-up
}

// Optionnel : Fermer le pop-up en cliquant à l'extérieur
window.addEventListener('click', (e) => {
    const popup = document.getElementById('popup');
    if (e.target === popup) {
        popup.style.display = 'none';
    }
});







function inscriptionenfant() {
    // Change the title
    document.getElementById('form-title').innerText = 'Formulaire d\'inscription de l\'enfant';

    // Show name fields

    document.getElementById('info-kids-fields').style.display = 'grid';

    document.getElementById('info-parents-fields').style.display = 'grid' ;

    document.getElementById('info-person-fields').style.display = 'none' ;

    document.getElementById('info-kids-fields').innerHTML= `
                    <div>
                        <label for="name">Nom de l'enfant :</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div>
                        <label for="surname">Prénom de l'enfant :</label>
                        <input type="text" id="surname" name="surname" required>
                    </div>
                        

                    <div>
                        <label for="Age">Date de naissance de l'enfant :</label>
                        <input type="date" id="Age" name="Age" required>    
                    </div>
                     
                    <div>
                        <label for="sexe">sexe de l'enfant :</label>
                        <input type="text" id="sexe" name="sexe" maxlength="1" required>  
                    </div>
`;

    document.getElementById('info-parents-fields').innerHTML = `<div>
    <label for="parentname">Nom du parent :</label>
<input type="text" id="parentname" name="parentname" required>
</div>

<div>
    <label for="parentsurname">Prénom du parent :</label>
    <input type="text" id="parentsurname" name="parentsurname" required>
</div>


<div>
    <label for="phone">Numéro de téléphone :</label>
    <input type="tel" id="phone" name="phone" required>  
</div>

<div>
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required> 
</div>`;

    document.getElementById('info-fields').innerHTML = `<label for="entenduparler">Comment avez-vous entendu parler de nous ? :</label>
    <input type="text" id="entenduparler" name="entenduparler" required>

    <label for="Condition">Condition médicale (vaccin, groupe sanguin, asthme, allergies, ...) :</label>
    <input type="text" id="Condition" name="Condition" required>`;

    document.getElementById('password-fields').style.display = ' grid' ;

    // Restore email and password fields to include verification
    document.getElementById('password-fields').innerHTML = `
    <div>
        <label for="password">Mot de passe :</label>
        <input id="password" name="password" required> 
    </div>

    <div>
        <label for="passwordverif">Vérification du Mot de passe :</label>
        <input id="passwordverif" name="passwordverif" required> 
    </div>
    `;

    var boutonpop1 = document.getElementById('toggle-button-1');
    boutonpop1.setAttribute('onclick', '');
    boutonpop1.setAttribute('name', 'togglebutton1');

    var boutonpop2 = document.getElementById('toggle-button-2');
    boutonpop2.setAttribute('onclick', 'inscription()');
    boutonpop2.setAttribute('name', '');

    var boutonpop3 = document.getElementById('toggle-button-3');
    boutonpop3.setAttribute('onclick', 'connexion()');
    boutonpop3.setAttribute('name', '');
    
}


function inscription() {
    // Change the title
    document.getElementById('form-title').innerText = 'Formulaire d\'inscription de l\'enfant';

    // Show name fields
    document.getElementById('info-kids-fields').style.display = 'none';
    document.getElementById('info-parents-fields').style.display = 'none';

    document.getElementById('info-person-fields').style.display = 'grid';

    document.getElementById('info-person-fields').innerHTML = `<div>
    <label for="name">Nom :</label>
<input type="text" id="name" name="name" required>
</div>

<div>
    <label for="surname">Prénom :</label>
    <input type="text" id="surname" name="surname" required>
</div>

<div>
                        <label for="Age">Date de naissance de l'enfant :</label>
                        <input type="date" id="Age" name="Age" required>    
                    </div>
                     
                    <div>
                        <label for="sexe">sexe de l'enfant :</label>
                        <input type="text" id="sexe" name="sexe" maxlength="1" required>  
                    </div>


<div>
    <label for="phone">Numéro de téléphone :</label>
    <input type="tel" id="phone" name="phone" required>  
</div>

<div>
    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required> 
</div>`;

    document.getElementById('info-fields').innerHTML = `

    
    <label for="entenduparler">Comment avez-vous entendu parler de nous ? :</label>
    <input type="text" id="entenduparler" name="entenduparler" required>

    <label for="Condition">Condition médicale (vaccin, groupe sanguin, asthme, allergies, ...) :</label>
    <input type="text" id="Condition" name="Condition" required>`;

    document.getElementById('password-fields').style.display = ' grid' ;

    // Restore email and password fields to include verification
    document.getElementById('password-fields').innerHTML = `
    <div>
        <label for="password">Mot de passe :</label>
        <input id="password" name="password" required> 
    </div>

    <div>
        <label for="passwordverif">Vérification du Mot de passe :</label>
        <input id="passwordverif" name="passwordverif" required> 
    </div>
    `;

    


    // Change the toggle button to switch back to login

    

    var boutonpop2 = document.getElementById('toggle-button-2');
    boutonpop2.setAttribute('onclick', '');
    boutonpop2.setAttribute('name', 'togglebutton2');


    var boutonpop1 = document.getElementById('toggle-button-1');
    boutonpop1.setAttribute('onclick', 'inscriptionenfant()');
    boutonpop1.setAttribute('name', '');

    var boutonpop3 = document.getElementById('toggle-button-3');
    boutonpop3.setAttribute('onclick', 'connexion()');
    boutonpop3.setAttribute('name', '');

    
}

function connexion() {
    // Change the title
    document.getElementById('form-title').innerText = 'Formulaire d\'inscription de l\'enfant';

    // Show name fields
    document.getElementById('info-kids-fields').style.display = 'none';

    document.getElementById('info-parents-fields').style.display = 'none' ;

    document.getElementById('info-person-fields').style.display = 'none' ;

    document.getElementById('info-fields').innerHTML = `<label for="email">Email :</label>
    <input type="email" id="email" name="email" required>  `;
    
    
    document.getElementById('password-fields').style.display = ' block' ;
    

    // Restore email and password fields to include verification
    document.getElementById('password-fields').innerHTML = `
    
        <label for="password">Mot de passe :</label>
        <input id="password" name="password" required> 
    `;

    

    


    // Change the toggle button to switch back to login
    

    var boutonpop1 = document.getElementById('toggle-button-1');
    boutonpop1.setAttribute('onclick', 'inscriptionenfant()');
    boutonpop1.setAttribute('name', '');

    var boutonpop2 = document.getElementById('toggle-button-2');
    boutonpop2.setAttribute('onclick', 'inscription()');
    boutonpop2.setAttribute('name', '');

    var boutonpop3 = document.getElementById('toggle-button-3');
    boutonpop3.setAttribute('onclick', '');
    boutonpop3.setAttribute('name', 'togglebutton3');
}











    </script>
