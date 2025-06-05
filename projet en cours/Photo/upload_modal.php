<div id="upload-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
    <div style="background:white; padding:20px; width:300px; margin:100px auto;">
        <h3>Ajouter des photos</h3>
        <form id="upload-form" method="post" enctype="multipart/form-data">
            <input type="text" name="publication_title" id="modal-publication-title" placeholder="Titre de la publication" required>  
            <input type="hidden" name="publication_id" id="modal-publication-id">
            <input type="file" name="photos[]" multiple accept="image/*">
            <button type="submit">Envoyer</button>
            <button type="button" onclick="document.getElementById('upload-modal').style.display='none'">Annuler</button>
        </form>
        <div id="upload-status"></div>
    </div>
</div>

<script>
document.getElementById('upload-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    document.getElementById('upload-status').innerHTML = 'Traitement en cours...';

    const formData = new FormData(this);
    const carouselId = document.getElementById('upload-modal').dataset.carouselId;

    fetch('upload_handler.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
    if (data.success) {
        document.getElementById('upload-status').innerHTML = 'Succès!';
        // Masquer la modale après succès
        document.getElementById('upload-modal').style.display = 'none';

        // Recharger les images (AJAX ou en rechargeant partiellement le carrousel)
        location.reload(); // 💡 Simple mais brutal : recharge toute la page

        // OU : appelle une fonction personnalisée pour recharger le carrousel seulement
        // reloadCarousel(); // À définir dans `java.js`
    } else {
        document.getElementById('upload-status').innerHTML = 'Erreur: ' + (data.error || 'inconnue');
    }
    
})
    })
    .catch(error => {
        document.getElementById('upload-status').innerHTML = 'Erreur: ' + error;
        submitBtn.disabled = false;
    });
</script>