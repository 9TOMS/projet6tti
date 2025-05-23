<?php
// Exemple : définir si l'utilisateur est admin (true/false)
$estAdmin = false; // ou false selon ta logique

// Poser le cookie isAdmin avant tout affichage
setcookie("isAdmin", $estAdmin ? "1" : "0", time() + 3600, "/");
if ((isset($_POST['submit'])))
{
    if (isset($_POST['Nom']))
    {
        if (isset($_POST['Prenom']))
        {
            if (isset($_POST['Email']))
            {
                if (isset($_POST['tel']))
                {
                    if (isset($_POST['number']))
                    {
                        $bdd = mysqli_connect('localhost','root', '','users');
                        mysqli_set_charset($bdd, "utf8");
                        $compteur = 0;
                        $requete =  "SELECT Pseudo_Utilisateur FROM users WHERE Statut_Utilisateur= 'Administrateur'";
                        $pseudo = mysqli_query($bdd,$requete);
                        while ($donnes = mysqli_fetch_assoc($pseudo)) 
                        {   
                            if ($donnes['Pseudo_Utilisateur'] == $_POST['pseudo'])
                            {
                                $compteur = $compteur + 1;
                            }
                        }
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <style>
        /* Styles généraux pour le corps de la page */
        body {
            font-family: 'Segoe UI', sans-serif;
            background: cyan;
            margin: 0;
            padding: 20px;
        }

        /* Zones d'agenda */
        .agenda-jour, .agenda-final {
            min-width: 1200px;
            margin: 0 auto;
        }

        /* Classes pour masquer les sections */
        .agenda-jour.hidden, .agenda-final.hidden {
            display: none;
        }

        /* Style de l'agenda du jour */
        .agenda-jour {
            text-align: center;
        }

        /* Style des cartes de jours dans l'agenda mensuel */
        .carte {
            background: white;
            border-radius: 10px;
            padding: 5px;
            display: grid;
            margin: 5px;
            text-align: center;
            height: 100px;
            overflow: auto;
            width: 200px;
        }

        /* Conteneur scrollable pour l'agenda mensuel */
        .agenda-mois {
            width: 1200px;
            height: 390px;
            border: 1px solid;
            overflow: auto;
            border-radius: 10px;
            background-color: rgba(0, 0, 0, 0.7);
        }

        /* Style des boutons d'événements */
        .bouton {
            padding: 4px 6px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            font-weight: bold;
            font-size: 10px;
            width: 100%;
        }

        /* Grille de semaine : 7 colonnes */
        .semaine {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 6px;
        }

        /* Style du titre de chaque carte */
        .carte h4 {
            margin: 0 0 10px 0;
            font-size: 20px;
        }

        /* Boutons verts pour les événements disponibles */
        .disponible {
            background-color: green;
            max-height: 20px;
            font-size: 15px;
        }

        /* Couleur rouge pour indisponible (non utilisée ici) */
        .indisponible {
            background-color: red;
        }

        /* Grille pour l'agenda journalier */
        .agenda {
            display: grid;
            grid-template-columns: 100px 1fr;
            width: 600px;
            height: 300px;
            margin: 20px auto;
            border: 1px solid black;
            background: white;
            overflow: hidden;
        }

        /* Ligne de temps : heures + événements */
        .time-slot {
            border-bottom: 1px solid black;
            padding: 2px;
        }

        /* Colonne des heures */
        .hour {
            background: cyan;
            border-right: 1px solid #ddd;
            font-weight: bold;
        }

        /* Cellule interactive pour les événements */
        .event-cell {
            cursor: pointer;
            position: relative;
        }

        /* Affichage d’un événement dans la cellule */
        .event {
            background-color: blue;
            color: white;
            padding: 5px;
            border-radius: 4px;
            font-size: 14px;
            position: absolute;
        }

        /* Bouton de retour */
        .back-button {
            background-color: blue;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }

        /* Ligne de séparation */
        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 10px 0;
        }

        /* Titre des agendas */
        .agenda-final h1,
        .agenda-jour h1 {
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Inclusion de l’en-tête -->
<?php include("entete.php"); ?>
<div class="page">
    <?php include("menu.php"); ?>

    <div id="agenda-custom">
        <!-- Section de l'agenda journalier, masquée par défaut -->
        <div class="agenda-jour hidden" id="agenda-jour">
            <h1 id="jour-titre">Agenda du jour</h1>
            <div class="agenda" id="agenda-journee"></div>
            <button class="back-button" onclick="retourAgendaFinal()">Retour à l'agenda</button>
        </div>

        <!-- Section de l'agenda mensuel -->
        <div class="agenda-final" id="agenda-final">
            <h1>Agenda</h1>
            <div id="agenda-final-contenu" class="agenda-mois"></div>
        </div>
    </div>
</div>

<!-- Inclusion du pied de page -->
<?php include("pied_de_page.php"); ?>

<script>
    function getCookie(name) 
    {
        const cookies = document.cookie.split(';');
        for (let cookie of cookies) {
            cookie = cookie.trim();
            if (cookie.startsWith(name + '=')) {
                return cookie.substring((name + '=').length);
            }
        }
        return null;
    }

    const isAdmin = getCookie("isAdmin") === "1";
    const agendaJourDiv = document.getElementById("agenda-jour");
    const agendaJournee = document.getElementById("agenda-journee");
    const jourTitre = document.getElementById("jour-titre");

    // Renvoie le lundi de la semaine correspondant à la date donnée
    function getStartOfWeek(date) {
        const d = new Date(date);
        const day = d.getDay();
        const diff = (day + 6) % 7; // permet d’avoir lundi comme début de semaine
        d.setDate(d.getDate() - diff);
        d.setHours(0, 0, 0, 0);
        return d;
    }

    // Format court en français : lun. 12 avr.
    function formatDateFR(date) {
        return date.toLocaleDateString("fr-FR", {
            weekday: "short", day: "numeric", month: "short"
        });
    }

    // Format long en français : lundi 12 avril 2025
    function formatDateLong(dateStr) {
        return new Date(dateStr).toLocaleDateString("fr-FR", {
            weekday: "long", year: "numeric", month: "long", day: "numeric"
        });
    }

    // Affiche l’agenda journalier d’une date précise
    function ouvrirAgendaJour(dateStr) {
        if (!isAdmin) {
        return;
    }
        document.getElementById("agenda-final").classList.add("hidden");
        agendaJourDiv.classList.remove("hidden");
        jourTitre.textContent = "Agenda du " + formatDateLong(dateStr);
        agendaJournee.innerHTML = "";

        for (let hour = 8; hour <= 18; hour++) {
            // Ajout de l’heure
            const timeRow = document.createElement("div");
            timeRow.className = "time-slot hour";
            timeRow.textContent = hour + ":00";
            agendaJournee.appendChild(timeRow);

            // Cellule événementielle
            const eventCell = document.createElement("div");
            eventCell.className = "time-slot event-cell";
            eventCell.dataset.time = hour + ":00";

            eventCell.addEventListener("click", () => {
                // Création du menu de choix d'événement
                const select = document.createElement("select");
                ["BALADES", "COURS", "STAGES"].forEach(optionText => {
                    const option = document.createElement("option");
                    option.value = optionText;
                    option.textContent = optionText;
                    select.appendChild(option);
                });

                // Boîte de confirmation
                const confirmation = document.createElement("div");
                confirmation.style.position = "fixed";
                confirmation.style.top = "50%";
                confirmation.style.left = "50%";
                confirmation.style.transform = "translate(-50%, -50%)";
                confirmation.style.background = "white";
                confirmation.style.padding = "20px";
                confirmation.style.border = "1px solid black";
                confirmation.style.zIndex = 1000;
                confirmation.style.textAlign = "center";
                confirmation.style.borderRadius = "8px";
                confirmation.style.boxShadow = "0 0 10px rgba(0,0,0,0.5)";

                const label = document.createElement("label");
                label.textContent = "Choisissez le type d'événement :";
                label.style.display = "block";
                label.style.marginBottom = "10px";

                const boutonValider = document.createElement("button");
                boutonValider.textContent = "Valider";
                boutonValider.style.marginTop = "10px";
                boutonValider.style.padding = "5px 10px";
                boutonValider.style.backgroundColor = "blue";
                boutonValider.style.color = "white";
                boutonValider.style.border = "none";
                boutonValider.style.borderRadius = "5px";
                boutonValider.style.cursor = "pointer";

                boutonValider.onclick = () => {
                    // Sauvegarde de l’événement
                    const eventName = select.value;
                    const eventDiv = document.createElement("div");
                    eventDiv.className = "event";
                    eventDiv.textContent = eventName;
                    eventCell.innerHTML = '';
                    eventCell.appendChild(eventDiv);

                    const saved = JSON.parse(localStorage.getItem("evenementsPerso") || "{}");
                    if (!saved[dateStr]) saved[dateStr] = [];
                    saved[dateStr].push({ time: eventCell.dataset.time, name: eventName });
                    localStorage.setItem("evenementsPerso", JSON.stringify(saved));

                    document.body.removeChild(confirmation);
                };

                confirmation.appendChild(label);
                confirmation.appendChild(select);
                confirmation.appendChild(boutonValider);
                document.body.appendChild(confirmation);
            });

            agendaJournee.appendChild(eventCell);
        }
    }

    // Retour à l'affichage de l'agenda mensuel
    function retourAgendaFinal() {
        agendaJourDiv.classList.add("hidden");
        document.getElementById("agenda-final").classList.remove("hidden");
    }

    // Affichage de l’agenda mensuel avec les événements
    function afficherAgendaFinal() {
        const liste = document.getElementById("agenda-final-contenu");
        liste.innerHTML = "";

        const evenements = JSON.parse(localStorage.getItem("evenementsPerso") || "{}");

        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const start = getStartOfWeek(today);
        const end = new Date(today);
        end.setMonth(end.getMonth() + 1);

        const allDays = [];
        for (let d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
            allDays.push(new Date(d));
        }

        let semaineDiv;
        for (let i = 0; i < allDays.length; i++) {
            const day = allDays[i];
            const dateStr = day.toISOString().split("T")[0];

            if (i % 7 === 0) {
                if (semaineDiv) liste.appendChild(semaineDiv);
                semaineDiv = document.createElement("div");
                semaineDiv.className = "semaine";
            }

            const titreJour = document.createElement("div");
            titreJour.className = "carte";
            titreJour.style.cursor = "pointer";

            const h4 = document.createElement("h4");
            h4.textContent = formatDateFR(day);
            titreJour.appendChild(h4);

            titreJour.addEventListener("click", () => {
                ouvrirAgendaJour(dateStr);
            });

            const events = evenements[dateStr] || [];
            if (events.length === 0) {
                const noEventMessage = document.createElement("div");
                noEventMessage.textContent = "Aucun événement";
                noEventMessage.style.fontStyle = "italic";
                titreJour.appendChild(noEventMessage);
            } else {
                events.forEach(event => {
                    const boutonEvent = document.createElement("button");
                    boutonEvent.className = "bouton disponible";
                    boutonEvent.style.margin = "5px 0";
                    boutonEvent.textContent = event.time + " — " + event.name;
                    boutonEvent.onclick = () => {
                    // Crée la boîte modale
                    const modal = document.createElement("div");
                    modal.style.position = "fixed";
                    modal.style.top = "50%";
                    modal.style.left = "50%";
                    modal.style.transform = "translate(-50%, -50%)";
                    modal.style.background = "white";
                    modal.style.padding = "20px";
                    modal.style.border = "1px solid black";
                    modal.style.zIndex = 1000;
                    modal.style.borderRadius = "10px";
                    modal.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.5)";
                    modal.style.Width = "500px";
                        modal.style.heigth = "800px";
                    // Titre
                    const title = document.createElement("h3");
                    title.textContent = "Formulaire d'inscription";
                    modal.appendChild(title);

                    // Formulaire
                    const form = document.createElement("form");
                    form.method = "post";

                    const labelNom = document.createElement("label");
                    labelNom.textContent = "Nom :";
                    form.appendChild(labelNom);

                    const inputNom = document.createElement("input");
                    inputNom.type = "text";
                    inputNom.name = "Nom";
                    inputNom.style.width = "100%";
                    inputNom.style.marginBottom = "10px";
                    form.appendChild(inputNom);
                    
                    // Prénom
                    const labelPrenom = document.createElement("label");
                    labelPrenom.textContent = "Prénom :";
                    form.appendChild(labelPrenom);

                    const inputPrenom = document.createElement("input");
                    inputPrenom.type = "text";
                    inputPrenom.name = "Prenom";
                    inputPrenom.style.width = "100%";
                    inputPrenom.style.marginBottom = "10px";
                    form.appendChild(inputPrenom);

                    const labelEmail = document.createElement("label");
                    labelEmail.textContent = "Email :";
                    form.appendChild(labelEmail);

                    const inputEmail = document.createElement("input");
                    inputEmail.type = "text";
                    inputEmail.name = "Email";
                    inputEmail.style.width = "100%";
                    inputEmail.style.marginBottom = "10px";
                    form.appendChild(inputEmail);

                    // Téléphone
                    const labelTel = document.createElement("label");
                    labelTel.textContent = "Téléphone :";
                    form.appendChild(labelTel);

                    const inputTel = document.createElement("input");
                    inputTel.type = "tel";
                    inputTel.name = "tel";
                    inputTel.style.width = "100%";
                    inputTel.style.marginBottom = "10px";
                    form.appendChild(inputTel);

                    // Nombre de personnes
                    const labelNb = document.createElement("label");
                    labelNb.textContent = "Nombre de personnes :";
                    form.appendChild(labelNb);

                    const inputNb = document.createElement("input");
                    inputNb.type = "number";
                    inputNb.name = "number";
                    inputNb.min = "1";
                    inputNb.style.width = "100%";
                    inputNb.style.marginBottom = "10px";
                    form.appendChild(inputNb);

                    // Boutons
                    const boutonFermer = document.createElement("button");
                    boutonFermer.textContent = "Fermer";
                    boutonFermer.type = "button";
                    boutonFermer.style.marginRight = "10px";
                    boutonFermer.onclick = () => document.body.removeChild(modal);

                    const boutonSauver = document.createElement("button");
                    boutonSauver.textContent = "Sauver";
                    boutonSauver.type = "submit";
                    boutonSauver.value = "submit";
                    boutonSauver.name = "submit";
                    
                    event.name;

                    form.appendChild(boutonFermer);
                    form.appendChild(boutonSauver);

                   

                    modal.appendChild(form);
                    document.body.appendChild(modal);
                };
                    titreJour.appendChild(boutonEvent);
                });
            }

            semaineDiv.appendChild(titreJour);
        }

        if (semaineDiv) {
            liste.appendChild(semaineDiv);
        }
    }

    // Chargement initial de l’agenda
    afficherAgendaFinal();
</script>
</body>
</html>
