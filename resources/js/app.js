// resources/js/app.js

// importar CSS principal (Vite vai processar isso)
import '../css/app.css';

// se você tiver mais css global, importe aqui também
// import '../css/components/form.css';
// import '../css/pet/create.css'; // apenas se quiser carregar globalmente

import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    console.log("Petshop Reservation System JS loaded!");

    // exemplo: botões de delete — garanta que os botões tenham a classe .delete-button
    const deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            if (!confirm('Are you sure you want to delete this item?')) {
                e.preventDefault();
            }
        });
    });
});
