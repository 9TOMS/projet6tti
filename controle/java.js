let heureDebut = new Date();
let nbr_max = 1024;
let nbr_aleatoire = Math.floor(Math.random() * nbr_max);
let nbr_coup = 0;

function test() {
    let nbr = document.getElementById('nbr').value;
    nbr_coup++;

    if (nbr == nbr_aleatoire) {
        let heureFin = new Date();
        let dureeMs = heureFin - heureDebut;

        let secondesTotales = Math.floor(dureeMs / 1000);
        let minutes = Math.floor(secondesTotales / 60);
        let secondes = secondesTotales % 60;

        let tempsTotal = `00:${minutes.toString().padStart(2, '0')}:${secondes.toString().padStart(2, '0')}`;
        let pseudo = "Ricma"; // tu peux récupérer dynamiquement si besoin

        // Affichage
        document.getElementById("duree_partie").innerText =
            `Durée de la partie : ${minutes} minute(s) et ${secondes} seconde(s)`;
        document.getElementById('text2').innerHTML = `Vous avez trouvé la solution en ${nbr_coup} coups`;
        document.getElementById('text1').innerHTML = "Standing ovation";

        document.documentElement.style.setProperty('--couleur', 'yellow');
        document.documentElement.style.setProperty('--bordure', '15px solid var(--couleur)');
        document.documentElement.style.setProperty('--couleur2_fond', 'yellow');

        // Sauvegarde dans localStorage
        localStorage.setItem("pseudo", pseudo);
        localStorage.setItem("coups", nbr_coup);
        localStorage.setItem("duree", tempsTotal);

        // Envoi au serveur PHP
        fetch('enregistrer_partie.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `pseudo=${encodeURIComponent(pseudo)}&coups=${nbr_coup}&temps=${encodeURIComponent(tempsTotal)}`
        })
        .then(response => response.text())
        .then(data => console.log("Réponse du serveur :", data))
        .catch(error => console.error("Erreur serveur :", error));
    } else {
        if (nbr > nbr_aleatoire) {
            document.getElementById('text2').innerHTML = "Le nombre à trouver est plus petit";
            document.documentElement.style.setProperty('--couleur', 'red');
            document.documentElement.style.setProperty('--bordure', '15px solid var(--couleur)');
        } else {
            document.getElementById('text2').innerHTML = "Le nombre à trouver est plus grand";
            document.documentElement.style.setProperty('--couleur', 'green');
            document.documentElement.style.setProperty('--bordure', '15px solid var(--couleur)');
        }
    }
}


// Mise à jour de l'heure actuelle (si tu veux toujours l'afficher en direct)
let heureInitiale = document.getElementById("heure_actuelle").innerText;
let [heures, minutes, secondes] = heureInitiale.split(':').map(Number);

function miseAJourHeure() {
    secondes++;
    if (secondes >= 60) {
        secondes = 0;
        minutes++;
    }
    if (minutes >= 60) {
        minutes = 0;
        heures++;
    }
    if (heures >= 24) {
        heures = 0;
    }

    let h = heures.toString().padStart(2, '0');
    let m = minutes.toString().padStart(2, '0');
    let s = secondes.toString().padStart(2, '0');

    document.getElementById("heure_actuelle").innerText = `${h}:${m}:${s}`;
}

// Mise à jour toutes les secondes
setInterval(miseAJourHeure, 1000);
