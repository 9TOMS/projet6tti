<?php
$bdd = mysqli_connect('localhost', 'root', '', 'crepuscule');
mysqli_set_charset($bdd, "utf8");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'inscription') {


    // Récupérer et sécuriser les données
    $evenement_id = intval($_POST['evenement_id']);
    $nom = mysqli_real_escape_string($bdd, $_POST['Nom']);
    $prenom = mysqli_real_escape_string($bdd, $_POST['Prenom']);
    $email = mysqli_real_escape_string($bdd, $_POST['Email']);
    $tel = mysqli_real_escape_string($bdd, $_POST['tel']);
    $nombre = intval($_POST['number']);

    $query = "INSERT INTO inscriptions (evenement_id, nom, prenom, email, tel, nombre_participants) VALUES ($evenement_id, '$nom', '$prenom', '$email', '$tel', $nombre)";
    if (mysqli_query($bdd, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($bdd)]);
    }
    exit;
}

// Gestion de la partie API REST interne pour les événements
if (isset($_GET['api']) && $_GET['api'] === 'evenements') {
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET') {
        if (isset($_GET['date'])) {
            $date = mysqli_real_escape_string($bdd, $_GET['date']);
            $query = "SELECT * FROM evenements WHERE date = '$date'";
        } else {
            $query = "SELECT * FROM evenements";
        }
        $result = mysqli_query($bdd, $query);
        $events = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $events[] = $row;
        }
        echo json_encode($events);
        exit;
    }

    if ($method === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        $date = mysqli_real_escape_string($bdd, $input['date']);
        $heure = mysqli_real_escape_string($bdd, $input['heure']);
        $nom = mysqli_real_escape_string($bdd, $input['nom']);

        $query = "INSERT INTO evenements (date, heure, nom) VALUES ('$date', '$heure', '$nom')";
        if (mysqli_query($bdd, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($bdd)]);
        }
        exit;
    }
    if ($method === 'DELETE') {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = intval($input['id']);
        $query = "DELETE FROM evenements WHERE id = $id";
        if (mysqli_query($bdd, $query)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($bdd)]);
        }
        exit;
    }

}
if (isset($_GET['api']) && $_GET['api'] === 'inscrits' && isset($_GET['evenement_id'])) {
    header('Content-Type: application/json');
    $evenement_id = intval($_GET['evenement_id']);

    $result = mysqli_query($bdd, "SELECT nom, prenom, email, tel, nombre_participants FROM inscriptions WHERE evenement_id=$evenement_id");
    $inscrits = [];
    $totalParticipants = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $inscrits[] = $row;
        $totalParticipants += intval($row['nombre_participants']);
    }

    echo json_encode([
        'total' => $totalParticipants,
        'inscrits' => $inscrits
    ]);
    exit;
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Contact</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="java.js"></script>
    <style>

        /* Styles généraux pour le corps de la page */
        body {
            font-family: 'Segoe UI', sans-serif;
            background: cyan;
            margin: 0;
            padding: 20px;
        }

        /* Zones d'agenda */
        .agenda-jour,
        .agenda-final {
            min-width: 1200px;
            margin: 0 auto;
        }

        /* Classes pour masquer les sections */
        .agenda-jour.hidden,
        .agenda-final.hidden {
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
            border: 1px solid rgba(200, 246, 217, 0.75);
            overflow: auto;
            border-radius: 10px;
            background-color: rgba(200, 246, 217, 0.75);
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
            border: 1px solid black rgba(200, 246, 217, 0.75); 
            background: white;
            overflow: hidden;
        }

        /* Ligne de temps : heures + événements */
        .time-slot {
            border-bottom: 1px solid black rgba(200, 246, 217, 0.75);
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
            border-top: 1px solid #ccc rgba(200, 246, 217, 0.75);
            margin: 10px 0;
        }

        /* Titre des agendas */
        .agenda-final h1,
        .agenda-jour h1 {
            text-align: center;
        }
        .agenda-jour,
.agenda-final,
.agenda-mois {
    max-width: 100%;
    width: 100%;
    margin: 0 auto;
    box-sizing: border-box;
}
html, body {
    margin: 0;
    padding: 0;
    height: 100vh;
    overflow: hidden; /* empêche le scroll */
    font-family: 'Segoe UI', sans-serif;
}

.page {
    display: flex;
    flex-direction: column;
    height: 100vh;
}
@media (max-width: 768px) {

 .carte {
        width: 100px;
        font-size: 14px;
    }

    .agenda {
        grid-template-columns: 60px 1fr;
        width: 400px;
        height: auto;
    }


    .agenda-jour, .agenda-final {
        width: 500px;
        margin: 0 auto;
    }

    .agenda-mois {
        width: 400px;
        height: 400px;
        max-height: 70vh;
    }

    .bouton {
        font-size: 12px;
        padding: 6px;
    }

}

    </style>
</head>

<body>
    <?php include("entete.php"); ?>
    <div class="page">

<main style="flex: 1; overflow: auto;">
        <div id="agenda-custom">
            <div class="agenda-jour hidden" id="agenda-jour">
                <h1 id="jour-titre">Agenda du jour</h1>
                <div class="agenda" id="agenda-journee"></div>
                <button class="back-button" onclick="retourAgendaFinal()">Retour à l'agenda</button>
            </div>

            <div class="agenda-final" id="agenda-final">
                <div id="agenda-final-contenu" class="agenda-mois"></div>
            </div>
        </div>
  </main>
    </div>
     <footer>
        <?php include("pied_de_page.php"); ?>
    </footer>

    <script>
        const isAdmin = <?php echo isset($_COOKIE['isAdmin']) && $_COOKIE['isAdmin'] === "1" ? 'true' : 'false'; ?>;


        const agendaJourDiv = document.getElementById("agenda-jour");
        const agendaJournee = document.getElementById("agenda-journee");
        const jourTitre = document.getElementById("jour-titre");

        // API interne
        async function getEvenements(dateStr) {
            const response = await fetch(`?api=evenements&date=${dateStr}`);
            return response.json();
        }

        async function saveEvenement(dateStr, heure, nom) {
            const response = await fetch('?api=evenements', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ date: dateStr, heure: heure, nom: nom })
            });
            const result = await response.json();
            return result.success;
        }

        // Fonctions inchangées...

        function getStartOfWeek(date) {
            const d = new Date(date);
            const day = d.getDay();
            const diff = (day + 6) % 7;
            d.setDate(d.getDate() - diff);
            d.setHours(0, 0, 0, 0);
            return d;
        }

        function formatDateFR(date) {
            return date.toLocaleDateString("fr-FR", {
                weekday: "short", day: "numeric", month: "short"
            });
        }

        function formatDateLong(dateStr) {
            return new Date(dateStr).toLocaleDateString("fr-FR", {
                weekday: "long", year: "numeric", month: "long", day: "numeric"
            });
        }

        async function ouvrirAgendaJour(dateStr) {
            if (!isAdmin) {
                return;
            }



            document.getElementById("agenda-final").classList.add("hidden");
            agendaJourDiv.classList.remove("hidden");
            jourTitre.textContent = "Agenda du " + formatDateLong(dateStr);
            agendaJournee.innerHTML = "";

            const events = await getEvenements(dateStr);

            for (let hour = 8; hour <= 18; hour++) {
                const timeRow = document.createElement("div");
                timeRow.className = "time-slot hour";
                timeRow.textContent = hour + ":00";
                agendaJournee.appendChild(timeRow);

                const eventCell = document.createElement("div");
                eventCell.className = "time-slot event-cell";
                eventCell.dataset.time = hour + ":00";

                // Remplir la cellule si un événement existe
                const event = events.find(e => e.heure === eventCell.dataset.time);
                if (event) {
                    const eventDiv = document.createElement("div");
                    eventDiv.className = "event";
                    eventDiv.textContent = event.nom;
                    if (isAdmin) {
                        const btnVoirInscrits = document.createElement("button");
                        btnVoirInscrits.textContent = "Voir inscrits";
                        btnVoirInscrits.style.marginLeft = "10px";
                        btnVoirInscrits.style.fontSize = "12px";
                        btnVoirInscrits.style.padding = "2px 5px";
                        btnVoirInscrits.style.cursor = "pointer";

                        btnVoirInscrits.onclick = async (e) => {
                            e.stopPropagation();

                            // Récupérer la liste des inscrits via API
                            const res = await fetch(`?api=inscrits&evenement_id=${event.id}`);
                            const data = await res.json();

                            // Créer modale pour afficher les inscrits
                            const modal = document.createElement("div");
                            modal.style.position = "fixed";
                            modal.style.top = "50%";
                            modal.style.left = "50%";
                            modal.style.transform = "translate(-50%, -50%)";
                            modal.style.background = "white";
                            modal.style.padding = "20px";
                            modal.style.border = "1px solid black rgba(200, 246, 217, 0.75)";
                            modal.style.zIndex = 10001;
                            modal.style.borderRadius = "8px";
                            modal.style.maxHeight = "80vh";
                            modal.style.overflowY = "auto";
                            modal.style.width = "400px";

                            const titre = document.createElement("h3");
                            titre.textContent = `Inscrits à "${event.nom}" (${event.heure}) - Total: ${data.total}`;
                            modal.appendChild(titre);

                            if (data.inscrits.length === 0) {
                                const p = document.createElement("p");
                                p.textContent = "Aucun inscrit pour cet événement.";
                                modal.appendChild(p);
                            } else {
                                const table = document.createElement("table");
                                table.style.width = "100%";
                                table.style.borderCollapse = "collapse";

                                const trHead = document.createElement("tr");
                                ["Nom", "Prénom", "Email", "Téléphone", "Nb participants"].forEach(headerText => {
                                    const th = document.createElement("th");
                                    th.textContent = headerText;
                                    th.style.border = "1px solid #ddd rgba(200, 246, 217, 0.75)";
                                    th.style.padding = "5px";
                                    th.style.textAlign = "left";
                                    trHead.appendChild(th);
                                });
                                table.appendChild(trHead);

                                data.inscrits.forEach(inscrit => {
                                    const tr = document.createElement("tr");
                                    ["nom", "prenom", "email", "tel", "nombre_participants"].forEach(field => {
                                        const td = document.createElement("td");
                                        td.textContent = inscrit[field];
                                        td.style.border = "1px solid #ddd rgba(200, 246, 217, 0.75)";
                                        td.style.padding = "5px";
                                        tr.appendChild(td);
                                    });
                                    table.appendChild(tr);
                                });

                                modal.appendChild(table);
                            }

                            const btnClose = document.createElement("button");
                            btnClose.textContent = "Fermer";
                            btnClose.style.marginTop = "10px";
                            btnClose.onclick = () => document.body.removeChild(modal);
                            modal.appendChild(btnClose);

                            document.body.appendChild(modal);
                        };

                        eventDiv.appendChild(btnVoirInscrits);
                    }
                    // Bouton supprimer
                    if (isAdmin) {
                        const btnDelete = document.createElement("button");
                        btnDelete.textContent = "×"; // Croisillon pour supprimer
                        btnDelete.title = "Supprimer cet événement";
                        btnDelete.style.position = "absolute";
                        btnDelete.style.top = "2px";
                        btnDelete.style.right = "2px";
                        btnDelete.style.background = "red";
                        btnDelete.style.color = "white";
                        btnDelete.style.border = "none";
                        btnDelete.style.borderRadius = "50%";
                        btnDelete.style.width = "18px";
                        btnDelete.style.height = "18px";
                        btnDelete.style.cursor = "pointer";
                        btnDelete.style.fontWeight = "bold";
                        btnDelete.style.fontSize = "14px";
                        btnDelete.style.lineHeight = "18px";
                        btnDelete.style.padding = "0";

                        btnDelete.onclick = async (e) => {
                            e.stopPropagation(); // Pour éviter d'ouvrir le select de création
                            if (confirm("Voulez-vous vraiment supprimer cet événement ?")) {
                                const res = await fetch('?api=evenements', {
                                    method: 'DELETE',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ id: event.id })
                                });
                                const data = await res.json();
                                if (data.success) {
                                    window.location.reload();// Rafraîchir l'affichage de la journée
                                } else {
                                    alert("Erreur lors de la suppression : " + data.error);
                                }
                            }
                        };

                        eventDiv.appendChild(btnDelete);
                    }
                    eventCell.appendChild(eventDiv);
                }

                eventCell.addEventListener("click", () => {
                    if (!isAdmin) return;

                    const select = document.createElement("select");
                    ["BALADES", "COURS", "STAGES"].forEach(opt => {
                        const option = document.createElement("option");
                        option.value = opt;
                        option.textContent = opt;
                        select.appendChild(option);
                    });

                    const inputPerso = document.createElement("input");
                    inputPerso.type = "text";
                    inputPerso.placeholder = "Ou saisissez un nom personnalisé";
                    inputPerso.style.display = "block";
                    inputPerso.style.marginTop = "10px";
                    inputPerso.style.width = "100%";

                    const confirmation = document.createElement("div");
                    confirmation.style.position = "fixed";
                    confirmation.style.top = "50%";
                    confirmation.style.left = "50%";
                    confirmation.style.transform = "translate(-50%, -50%)";
                    confirmation.style.background = "white";
                    confirmation.style.padding = "20px";
                    confirmation.style.border = "1px solid rgba(200, 246, 217, 0.75)";
                    confirmation.style.zIndex = "1000";
                    confirmation.style.textAlign = "center";
                    confirmation.style.borderRadius = "8px";
                    confirmation.style.boxShadow = "0 0 10px rgba(200, 246, 217, 0.75)";
                    confirmation.style.width = "300px";

                    const label = document.createElement("label");
                    label.textContent = "Choisissez le type d'événement ou saisissez un nom :";
                    label.style.display = "block";
                    label.style.marginBottom = "10px";

                    const boutonValider = document.createElement("button");
                    boutonValider.textContent = "Valider";
                    boutonValider.style.marginTop = "15px";
                    boutonValider.style.padding = "5px 10px";
                    boutonValider.style.backgroundColor = "blue";
                    boutonValider.style.color = "white";
                    boutonValider.style.border = "none";
                    boutonValider.style.borderRadius = "5px";
                    boutonValider.style.cursor = "pointer";

                    boutonValider.onclick = async () => {
                        const eventName = inputPerso.value.trim() !== "" ? inputPerso.value.trim() : select.value;
                        const success = await saveEvenement(dateStr, eventCell.dataset.time, eventName);
                        if (success) {
                            window.location.reload();
                        } else {
                            alert("Erreur lors de la sauvegarde.");
                        }
                        document.body.removeChild(confirmation);
                    };

                    confirmation.appendChild(label);
                    confirmation.appendChild(select);
                    confirmation.appendChild(inputPerso);
                    confirmation.appendChild(boutonValider);
                    document.body.appendChild(confirmation);
                });


                agendaJournee.appendChild(eventCell);
            }
        }

        function retourAgendaFinal() {
            agendaJourDiv.classList.add("hidden");
            document.getElementById("agenda-final").classList.remove("hidden");
        }

        async function afficherAgendaFinal() {

            const liste = document.getElementById("agenda-final-contenu");
            liste.innerHTML = "";

            // Récupération de tous les événements
            const evenements = await (await fetch('?api=evenements')).json();

            // Regrouper par date
            const eventsByDate = {};
            evenements.forEach(e => {
                if (!eventsByDate[e.date]) eventsByDate[e.date] = [];
                eventsByDate[e.date].push(e);
            });

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
                const dateStr = day.getFullYear() + '-' +
                    String(day.getMonth() + 1).padStart(2, '0') + '-' +
                    String(day.getDate()).padStart(2, '0');

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
                    if (isAdmin) {
                        ouvrirAgendaJour(dateStr);
                    } else {
                        ouvrirFormulaireInscription(dateStr);
                    }
                });

                const events = eventsByDate[dateStr] || [];
                events.forEach(ev => {
                    const eventDiv = document.createElement("div");
                    eventDiv.textContent = ev.heure + " " + ev.nom;
                    eventDiv.style.backgroundColor = "#d7e7fa";
                    eventDiv.style.margin = "2px 0";
                    eventDiv.style.padding = "2px 5px";
                    eventDiv.style.borderRadius = "4px";
                    titreJour.appendChild(eventDiv);
                });

                semaineDiv.appendChild(titreJour);
            }

            if (semaineDiv) liste.appendChild(semaineDiv);
        }
        // Nouvelle fonction pour afficher un formulaire d'inscription
        async function ouvrirFormulaireInscription(dateStr) {
            // Récupérer les événements du jour
            const events = await getEvenements(dateStr);

            // Créer la modale
            const modal = document.createElement("div");
            modal.style.position = "fixed";
            modal.style.top = "50%";
            modal.style.left = "50%";
            modal.style.transform = "translate(-50%, -50%)";
            modal.style.background = "white";
            modal.style.padding = "20px";
            modal.style.border = "1px solid rgba(200, 246, 217, 0.75)";
            modal.style.zIndex = 10000;
            modal.style.borderRadius = "8px";
            modal.style.width = "300px";
            modal.style.maxHeight = "80vh";
            modal.style.overflowY = "auto";
            modal.style.boxShadow = "0 0 10px rgba(200, 246, 217, 0.75)";

            const titre = document.createElement("h3");
            titre.textContent = "Inscription aux événements du " + formatDateLong(dateStr);
            modal.appendChild(titre);

            if (events.length === 0) {
                const aucun = document.createElement("p");
                aucun.textContent = "Aucun événement ce jour.";
                modal.appendChild(aucun);
            } else {
                // Liste des événements
                events.forEach(ev => {
                    const evDiv = document.createElement("div");
                    evDiv.style.marginBottom = "10px";

                    const evTitre = document.createElement("strong");
                    evTitre.textContent = ev.heure + " - " + ev.nom;
                    evDiv.appendChild(evTitre);

                    // Formulaire d'inscription par événement
                    const form = document.createElement("form");
                    form.style.marginTop = "5px";

                    // Nom
                    const inputNom = document.createElement("input");
                    inputNom.type = "text";
                    inputNom.name = "Nom";
                    inputNom.placeholder = "Nom";
                    inputNom.required = true;
                    inputNom.style.width = "100%";
                    inputNom.style.marginBottom = "5px";
                    form.appendChild(inputNom);

                    // Prénom
                    const inputPrenom = document.createElement("input");
                    inputPrenom.type = "text";
                    inputPrenom.name = "Prenom";
                    inputPrenom.placeholder = "Prénom";
                    inputPrenom.required = true;
                    inputPrenom.style.width = "100%";
                    inputPrenom.style.marginBottom = "5px";
                    form.appendChild(inputPrenom);

                    // Email
                    const inputEmail = document.createElement("input");
                    inputEmail.type = "email";
                    inputEmail.name = "Email";
                    inputEmail.placeholder = "Email";
                    inputEmail.required = true;
                    inputEmail.style.width = "100%";
                    inputEmail.style.marginBottom = "5px";
                    form.appendChild(inputEmail);

                    // Téléphone
                    const inputTel = document.createElement("input");
                    inputTel.type = "tel";
                    inputTel.name = "tel";
                    inputTel.placeholder = "Téléphone";
                    inputTel.style.width = "100%";
                    inputTel.style.marginBottom = "5px";
                    form.appendChild(inputTel);

                    // Nombre de participants
                    const inputNumber = document.createElement("input");
                    inputNumber.type = "number";
                    inputNumber.name = "number";
                    inputNumber.min = 1;
                    inputNumber.value = 1;
                    inputNumber.style.width = "100%";
                    inputNumber.style.marginBottom = "5px";
                    form.appendChild(inputNumber);

                    // Bouton submit
                    const submitBtn = document.createElement("button");
                    submitBtn.type = "submit";
                    submitBtn.textContent = "S'inscrire";
                    submitBtn.style.width = "100%";
                    submitBtn.style.padding = "5px";
                    submitBtn.style.backgroundColor = "green";
                    submitBtn.style.color = "white";
                    submitBtn.style.border = "none";
                    submitBtn.style.borderRadius = "5px";
                    form.appendChild(submitBtn);

                    // Gestion du submit
                    form.onsubmit = async (e) => {
                        e.preventDefault();

                        const formData = new FormData(form);

                        // Ajouter l'id de l'événement dans formData
                        formData.append('evenement_id', ev.id);
                        formData.append('action', 'inscription'); // pour savoir qu'on traite une inscription

                        const response = await fetch('', {
                            method: 'POST',
                            body: formData
                        });
                        const result = await response.json();

                        if (result.success) {
                            alert("Inscription enregistrée pour " + ev.nom + " à " + ev.heure);
                            document.body.removeChild(modal);
                        } else {
                            alert("Erreur lors de l'inscription : " + result.error);
                        }
                    };

                    evDiv.appendChild(form);
                    modal.appendChild(evDiv);
                });
            }

            // Bouton fermer
            const btnFermer = document.createElement("button");
            btnFermer.textContent = "Fermer";
            btnFermer.style.marginTop = "10px";
            btnFermer.style.width = "100%";
            btnFermer.style.padding = "5px";
            btnFermer.style.backgroundColor = "red";
            btnFermer.style.color = "white";
            btnFermer.style.border = "none";
            btnFermer.style.borderRadius = "5px";
            btnFermer.onclick = () => {
                document.body.removeChild(modal);
            };
            modal.appendChild(btnFermer);

            document.body.appendChild(modal);
        }

        // Initialisation
        afficherAgendaFinal();

    </script>
</body>

</html>
