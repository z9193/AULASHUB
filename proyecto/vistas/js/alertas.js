function alertas_ajax(alerta) {
    if (alerta.Alerta === "simple") {
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            icon: alerta.Tipo,
            confirmButtonText: 'Aceptar'
        });
    } else if (alerta.Alerta === "recargar") {
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            icon: alerta.Tipo,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            // Recarga siempre al cerrar la alerta, sea por botón o por fuera
            location.reload();
        });
    } else if (alerta.Alerta === "limpiar") {
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            icon: alerta.Tipo,
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            document.querySelectorAll(".FormularioAjax").forEach(form => form.reset());
        });
    } else if (alerta.Alerta === "redireccionar") {
        // CASO FALTANTE: Para cuando el controlador manda a otra página
        window.location.href = alerta.URL;
    }
}