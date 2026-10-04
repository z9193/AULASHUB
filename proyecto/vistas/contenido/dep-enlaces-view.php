<div class="container-fluid mb-4">
    <div class="full-box page-header">
        <h3 class="text-left text-uppercase">
            <i class="fas fa-link fa-fw"></i> &nbsp; VINCULAR DEPARTAMENTO CON ENLACE
        </h3>
        <p class="text-justify text-muted">
            Selecciona un departamento y un enlace disponible para crear el vínculo.
        </p>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="FormularioAjax form-neon bg-white border p-4"
                action="<?php echo SERVERURL; ?>Ajax/depEnlajax.php"
                method="POST"
                data-form="save"
                autocomplete="off">

                <input type="hidden" name="accion" value="vincular">

                <div class="row align-items-end">
                    <div class="col-12 col-md-5">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Departamento</label>
                            <select class="form-control" name="dep_id" id="sel_departamento" required>
                                <option value="">Seleccione un departamento...</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-5">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Enlace Disponible</label>
                            <select class="form-control" name="enlace_id" id="sel_enlace" required>
                                <option value="">Seleccione un enlace...</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label for="dep_vigente" class="form-label fw-bold">Estado</label>
                                <input type="text" class="form-control" value="VIGENTE" readonly>
                                <input type="hidden" name="depEnl_vig_reg" value="1">
                            </div>
                        </div>

                    <div class="col-12 col-md-2">
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary btn-block w-100">
                                <i class="fas fa-link"></i> &nbsp; Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <hr> <div class="container-fluid mt-4">
                <h4 class="mb-3 text-muted"><i class="fas fa-list-ul"></i> Vínculos Actuales</h4>
                <div class="table-responsive"> 
                    <table class="table table-hover table-bordered text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Departamento</th>
                                <th>Enlace</th>
                                <th>Eliminar</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-vinculos">
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Carga los <select> al abrir la página
(function(){
    const ajaxUrl = '<?php echo SERVERURL; ?>Ajax/depEnlajax.php';

    fetch(ajaxUrl, {
        method: 'POST',
        body: new URLSearchParams({ accion: 'cargar_selects' })
    })
    .then(res => res.json())
    .then(data => {
        const selDep = document.getElementById('sel_departamento');
        const selEnl = document.getElementById('sel_enlace');

        data.departamentos.forEach(dep => {
            const opt = document.createElement('option');
            opt.value       = dep.IdDepartamento_enc; // encriptado desde el modelo
            opt.textContent = dep.Nombre;
            selDep.appendChild(opt);
        });

        data.enlaces.forEach(enl => {
            const opt = document.createElement('option');
            opt.value       = enl.IdEnlace_enc;       // encriptado desde el modelo
            opt.textContent = enl.Nombre;
            selEnl.appendChild(opt);
        });
    })
    .catch(err => console.error('Error cargando selects:', err));
    function cargarTabla() {
    let datos = new FormData();
    datos.append("accion", "listar_vinculos");

    fetch("<?php echo SERVERURL; ?>Ajax/depEnlajax.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.text()) // Usamos .text() porque el controlador devuelve HTML (las filas <tr>)
    .then(html => {
        document.getElementById('tabla-vinculos').innerHTML = html;
    })
    .catch(error => console.log("Error:", error));
}

// Llama a la función al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    cargarTabla();
});
})();
</script>