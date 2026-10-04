// main.js
document.addEventListener('DOMContentLoaded', function() {

    document.addEventListener('submit', function(e) {
        if (e.target.classList.contains('FormularioAjax')) {
            e.preventDefault();

            let data   = new FormData(e.target);
            let action = e.target.getAttribute('action');
            let method = e.target.getAttribute('method');

            fetch(action, { method: method, body: data })
                .then(res => res.json())
                .then(res => alertas_ajax(res))
                .catch(err => console.error('Error Ajax:', err)); // ← atrapa errores de red
        }
    });

});