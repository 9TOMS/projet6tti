document.addEventListener('DOMContentLoaded', () => {
    const stages = document.querySelectorAll('.stage');
    const coursForm = document.getElementById('form-cours');
    const baladesForm = document.getElementById('form-balades');

    stages.forEach(stage => {
        stage.addEventListener('click', () => {
            const stageName = stage.dataset.stage;
            alert(`Vous avez sélectionné : ${stageName}`);
        });
    });
});
