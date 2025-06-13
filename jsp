 <?php
$bdd = mysqli_connect('localhost', 'root', '', 'crepuscule');
require_once("connexion_bd.php");
if ((isset($_COOKIE['admin'])) && ($_COOKIE['admin'] == true)) {
    $isAdmin = true;
    
    //echo "<script>const isAdmin = true;</script>";
    
} else {
    $isAdmin = false;
    //echo "<script>const isAdmin = false;</script>";
}


mysqli_set_charset($bdd, "utf8");
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'inscription') {
    $evenement_id = intval($_POST['evenement_id']);
    $nom = mysqli_real_escape_string($bdd, $_POST['Nom']);
    $prenom = mysqli_real_escape_string($bdd, $_POST['Prenom']);
    $email = mysqli_real_escape_string($bdd, $_POST['Email']);
    $tel = mysqli_real_escape_string($bdd, $_POST['tel']);
    $nombre = intval($_POST['number']);

    // Vérifier le quota
    // Récupérer le nombre total de personnes déjà inscrites
    $resTotal = mysqli_query($bdd, "SELECT SUM(nombre_participants) AS total FROM inscriptions WHERE evenement_id = $evenement_id");
    $rowTotal = mysqli_fetch_assoc($resTotal);
    $totalInscrits = intval($rowTotal['total']);

    // Récupérer le max autorisé
    $resMax = mysqli_query($bdd, "SELECT max_participants FROM evenements WHERE id = $evenement_id");
    $rowMax = mysqli_fetch_assoc($resMax);
    $max = intval($rowMax['max_participants']);

    if ($max > 0 && ($totalInscrits + $nombre > $max)) {
        // ❌ Trop d'inscrits, on refuse
        echo json_encode([
            'success' => false,
            'error' => "Il n'y a plus assez de places disponibles pour cet événement."
        ]);
        exit;
    }

    // Si ok, on insère
    $query = "INSERT INTO inscriptions (evenement_id, nom, prenom, email, tel, nombre_participants)
              VALUES ($evenement_id, '$nom', '$prenom', '$email', '$tel', $nombre)";
    
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
        $heure_debut = isset($input['heure_debut']) ? mysqli_real_escape_string($bdd, $input['heure_debut']) : null;
        $heure_fin = isset($input['heure_fin']) ? mysqli_real_escape_string($bdd, $input['heure_fin']) : null;
        $date_debut = isset($input['date_debut']) ? mysqli_real_escape_string($bdd, $input['date_debut']) : null;
        $date_fin = isset($input['date_fin']) ? mysqli_real_escape_string($bdd, $input['date_fin']) : null;
       $max_participants = isset($input['max_participants']) ? intval($input['max_participants']) : 0;

        $query = "INSERT INTO evenements (date, heure, nom, heure_debut, heure_fin, date_debut, date_fin, max_participants)
        VALUES (
            '$date',
            '$heure',
            '$nom',
            " . ($heure_debut ? "'$heure_debut'" : "NULL") . ",
            " . ($heure_fin ? "'$heure_fin'" : "NULL") . ",
            " . ($date_debut ? "'$date_debut'" : "NULL") . ",
            " . ($date_fin ? "'$date_fin'" : "NULL") . ",
            $max_participants
        )";



    
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
            width: 1200px;
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
        .evenement-multijour {
            background-color: #ffdb99; /* orange clair */
            font-weight: bold;
            border-left: 5px solid orange;
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
     @media (max-width: 768px) {
    .agenda-jour,
    .agenda-final {
        width: 100%;
        padding: 0 10px;
        box-sizing: border-box;
        height: auto;
    }

    .agenda-mois {
        width: 500px;
        height: auto;
        max-height: 70vh;
        overflow-y: auto;
        padding: 10px;
        box-sizing: border-box;
    }

    .semaine {
        grid-template-columns: repeat(7, 1fr); /* 2 colonnes */
        gap: 10px;
    }

    .carte {
        width: 100px;
        height: 100px;
        padding: 10px;
        font-size: 14px;
    }

    .carte h4 {
        font-size: 16px;
    }

    .agenda {
        grid-template-columns: 60px 1fr;
        width: 100%;
        height: auto;
        margin: 10px 0;
        overflow-x: auto;
    }

    .bouton,
    .back-button {
        font-size: 14px;
        padding: 8px;
    }

    hr {
        margin: 5px 0;
    }
    main
    {
        flex: 1; 
        overflow: auto;
    }
}
</style>
</head>
<body>
<?php include("entete.php"); ?>
<div class="page">
    <?php include("menu.php"); ?>
    <main >
        <div id="agenda-custom">
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


const jourTitre = document.getElementById("jour-titre");

// API interne
async function getEvenements(dateStr) {
    const response = await fetch(`?api=evenements&date=${dateStr}`);
    return response.json();
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

function ouvrirFormulaireCreation(dateStr, heure = "08:00") {
    const eventCell = { dataset: { time: heure } };

    // === Code copié de eventCell.addEventListener("click", ...) ===
    const inputNom = document.createElement("input");
    inputNom.type = "text";
    inputNom.placeholder = "Nom de l'événement";
    inputNom.required = true;
    inputNom.style.width = "100%";
    inputNom.style.marginTop = "10px";

    const inputMax = document.createElement("input");
    inputMax.type = "number";
    inputMax.placeholder = "Nombre maximum d'inscriptions";
    inputMax.min = 1;
    inputMax.required = true;
    inputMax.style.width = "100%";
    inputMax.style.marginTop = "10px";

    const chkHeure = document.createElement("input");
    chkHeure.type = "checkbox";
    const lblHeure = document.createElement("label");
    lblHeure.textContent = " Définir une heure de début et fin";
    lblHeure.style.display = "block";
    lblHeure.prepend(chkHeure);

    const chkDate = document.createElement("input");
    chkDate.type = "checkbox";
    const lblDate = document.createElement("label");
    lblDate.textContent = " Définir une date de début et fin";
    lblDate.style.display = "block";
    lblDate.prepend(chkDate);

    const inputHeureDebut = document.createElement("input");
    inputHeureDebut.type = "time";
    inputHeureDebut.style.display = "none";
    inputHeureDebut.style.marginTop = "5px";

    const inputHeureFin = document.createElement("input");
    inputHeureFin.type = "time";
    inputHeureFin.style.display = "none";
    inputHeureFin.style.marginTop = "5px";

    const inputDateDebut = document.createElement("input");
    inputDateDebut.type = "date";
    inputDateDebut.style.display = "none";
    inputDateDebut.style.marginTop = "5px";

    const inputDateFin = document.createElement("input");
    inputDateFin.type = "date";
    inputDateFin.style.display = "none";
    inputDateFin.style.marginTop = "5px";

    chkHeure.onchange = () => {
        inputHeureDebut.style.display = chkHeure.checked ? "block" : "none";
        inputHeureFin.style.display = chkHeure.checked ? "block" : "none";
    };

    chkDate.onchange = () => {
        inputDateDebut.style.display = chkDate.checked ? "block" : "none";
        inputDateFin.style.display = chkDate.checked ? "block" : "none";
    };

    const confirmation = document.createElement("div");
    confirmation.style.position = "fixed";
    confirmation.style.top = "50%";
    confirmation.style.left = "50%";
    confirmation.style.transform = "translate(-50%, -50%)";
    confirmation.style.background = "white";
    confirmation.style.padding = "20px";
    confirmation.style.border = "1px solid black";
    confirmation.style.zIndex = "1000";
    confirmation.style.textAlign = "center";
    confirmation.style.borderRadius = "8px";
    confirmation.style.boxShadow = "0 0 10px rgba(0,0,0,0.5)";
    confirmation.style.width = "300px";

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
        const bodyData = {
            date: dateStr,
            heure: eventCell.dataset.time,
            nom: inputNom.value.trim(),
            max_participants: parseInt(inputMax.value)
        };

        if (chkHeure.checked) {
            bodyData.heure_debut = inputHeureDebut.value;
            bodyData.heure_fin = inputHeureFin.value;
        }
        if (chkDate.checked) {
            bodyData.date_debut = inputDateDebut.value;
            bodyData.date_fin = inputDateFin.value;
        }

        const response = await fetch('?api=evenements', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(bodyData)
        });

        const result = await response.json();

        if (result.success) {
            window.location.reload();
        } else {
            alert("Erreur lors de la sauvegarde : " + result.error);
        }

        document.body.removeChild(confirmation);
    };
    const boutonFermer = document.createElement("button");
boutonFermer.textContent = "Fermer";
boutonFermer.style.marginTop = "10px";
boutonFermer.style.marginLeft = "10px";
boutonFermer.style.padding = "5px 10px";
boutonFermer.style.backgroundColor = "gray";
boutonFermer.style.color = "white";
boutonFermer.style.border = "none";
boutonFermer.style.borderRadius = "5px";
boutonFermer.style.cursor = "pointer";

boutonFermer.onclick = () => {
    document.body.removeChild(confirmation);
};

    confirmation.appendChild(inputNom);
    confirmation.appendChild(inputMax);
    confirmation.appendChild(lblHeure);
    confirmation.appendChild(inputHeureDebut);
    confirmation.appendChild(inputHeureFin);
    confirmation.appendChild(lblDate);
    confirmation.appendChild(inputDateDebut);
    confirmation.appendChild(inputDateFin);
   const boutonContainer = document.createElement("div");
boutonContainer.style.display = "flex";
boutonContainer.style.justifyContent = "space-between";
boutonContainer.style.marginTop = "15px";
boutonContainer.appendChild(boutonValider);
boutonContainer.appendChild(boutonFermer);

confirmation.appendChild(boutonContainer);

    document.body.appendChild(confirmation);
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
    if (e.date_debut && e.date_fin) {
        const start = new Date(e.date_debut);
        const end = new Date(e.date_fin);
        for (let d = new Date(start); d <= end; d.setDate(d.getDate() + 1)) {
            const dStr = d.toISOString().split("T")[0];
            if (!eventsByDate[dStr]) eventsByDate[dStr] = [];
            eventsByDate[dStr].push(e);
        }
    } else {
        const dStr = e.date;
        if (!eventsByDate[dStr]) eventsByDate[dStr] = [];
        eventsByDate[dStr].push(e);
    }
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
       if ($isAdmin) {
    ouvrirFormulaireCreation(dateStr, "08:00"); // 08:00 par défaut
} else {
    ouvrirFormulaireInscription(dateStr);
}
        });

        const events = eventsByDate[dateStr] || [];
        events.forEach(ev => {
            const eventDiv = document.createElement("div");
            let texte = ev.nom;

// Afficher les heures de début/fin si présentes
if (ev.heure_debut && ev.heure_fin) {
    texte += ` (${ev.heure_debut} → ${ev.heure_fin})`;
} 
// Sinon afficher les dates de début/fin si présentes
else if (ev.date_debut && ev.date_fin) {
    texte += ` (${ev.date_debut} → ${ev.date_fin})`;
}
// Sinon heure simple
else if (ev.heure) {
    texte = `${ev.heure} - ${texte}`;
}
eventDiv.classList.add("evenement");
if (ev.date_debut && ev.date_fin) {
    eventDiv.classList.add("evenement-multijour"); // 🎯 ici
}
eventDiv.style.display = "flex";
eventDiv.style.justifyContent = "space-between";
eventDiv.style.alignItems = "center";

const spanNom = document.createElement("span");
spanNom.textContent = texte;
eventDiv.appendChild(spanNom);

if ($isAdmin) {
    // === Bouton Voir inscrits ===
    const btnVoir = document.createElement("button");
    btnVoir.textContent = "👁️";
    btnVoir.title = "Voir inscrits";
    btnVoir.style.marginLeft = "5px";
    btnVoir.style.fontSize = "10px";
    btnVoir.style.padding = "2px 4px";
    btnVoir.style.cursor = "pointer";

    btnVoir.onclick = async (e) => {
        e.stopPropagation();
        const res = await fetch(`?api=inscrits&evenement_id=${ev.id}`);
        const data = await res.json();

        const modal = document.createElement("div");
        modal.style.position = "fixed";
        modal.style.top = "50%";
        modal.style.left = "50%";
        modal.style.transform = "translate(-50%, -50%)";
        modal.style.background = "white";
        modal.style.padding = "20px";
        modal.style.border = "1px solid black";
        modal.style.zIndex = 10001;
        modal.style.borderRadius = "8px";
        modal.style.maxHeight = "80vh";
        modal.style.overflowY = "auto";
        modal.style.width = "400px";

        const titre = document.createElement("h3");
        titre.textContent = `Inscrits à "${ev.nom}" - Total: ${data.total}`;
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
            ["Nom", "Prénom", "Email", "Téléphone", "Nb"].forEach(text => {
                const th = document.createElement("th");
                th.textContent = text;
                th.style.border = "1px solid #ddd";
                th.style.padding = "4px";
                table.appendChild(trHead);
                trHead.appendChild(th);
            });

            data.inscrits.forEach(inscrit => {
                const tr = document.createElement("tr");
                ["nom", "prenom", "email", "tel", "nombre_participants"].forEach(key => {
                    const td = document.createElement("td");
                    td.textContent = inscrit[key];
                    td.style.border = "1px solid #ddd";
                    td.style.padding = "4px";
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

    // === Bouton Supprimer ===
    const btnDelete = document.createElement("button");
    btnDelete.textContent = "✖";
    btnDelete.title = "Supprimer";
    btnDelete.style.marginLeft = "5px";
    btnDelete.style.fontSize = "10px";
    btnDelete.style.padding = "2px 5px";
    btnDelete.style.color = "white";
    btnDelete.style.background = "red";
    btnDelete.style.border = "none";
    btnDelete.style.borderRadius = "4px";
    btnDelete.style.cursor = "pointer";

    btnDelete.onclick = async (e) => {
        e.stopPropagation();
        if (confirm("Supprimer cet événement ?")) {
            const res = await fetch('?api=evenements', {
                method: 'DELETE',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({id: ev.id})
            });
            const data = await res.json();
            if (data.success) {
                afficherAgendaFinal(); // Mettre à jour sans recharger
            } else {
                alert("Erreur lors de la suppression : " + data.error);
            }
        }
    };

    const boutonContainer = document.createElement("div");
    boutonContainer.style.display = "flex";
    boutonContainer.appendChild(btnVoir);
    boutonContainer.appendChild(btnDelete);
    eventDiv.appendChild(boutonContainer);
}


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
    modal.style.border = "1px solid black";
    modal.style.zIndex = 10000;
    modal.style.borderRadius = "8px";
    modal.style.width = "300px";
    modal.style.maxHeight = "80vh";
    modal.style.overflowY = "auto";
    modal.style.boxShadow = "0 0 10px rgba(0,0,0,0.5)";

    const titre = document.createElement("h3");
    titre.textContent = "Inscription aux événements du " + formatDateLong(dateStr);
    modal.appendChild(titre);

    if(events.length === 0) {
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
