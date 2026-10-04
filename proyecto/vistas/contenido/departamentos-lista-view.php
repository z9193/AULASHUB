<div class="container-fluid mb-4">
    <div class="full-box page-header">
        <h3 class="text-left text-uppercase">
            <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE DEPARTAMENTOS
        </h3>
        <p class="text-justify text-muted">
            Administra los departamentos registrados en el sistema. Puedes ver detalles, editar o eliminar registros.
        </p>
    </div>

    <div class="container-fluid">
        <ul class="nav nav-tabs nav-justified mb-4 text-uppercase">
            <li class="nav-item">
                <a class="nav-link text-dark" href="<?php echo SERVERURL; ?>departamentos/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR DEPARTAMENTO</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active text-danger fw-bold" href="<?php echo SERVERURL; ?>departamentos-lista/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE DEPARTAMENTOS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="<?php echo SERVERURL; ?>departamentos-buscar/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR DEPARTAMENTO</a>
            </li>
        </ul>
    </div>

    <div class="container-fluid">
        <div class="table-responsive shadow-sm bg-white p-3 border">
            <table class="table table-hover table-bordered align-middle table-sm">
                <thead class="bg-light">
                    <tr class="text-center fw-bold">
                        <th>#</th>
                        <th>ID</th> <th>NOMBRE</th> 
                        <th>ESTADO</th>
                        <th>ACTUALIZAR</th>
                        <th>ELIMINAR</th>
                    </tr>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        echo $filas; 
                    ?>
                </tbody>
            </table>
            
            <div class="mt-3 text-center">
                <?php echo $paginador; ?>
            </div>
            </div>

<!-- Modal Actualizar -->
<div class="modal fade" id="modalActualizarDep" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-sync-alt"></i> &nbsp; Actualizar Departamento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="FormularioAjax"
                    action="<?php echo SERVERURL; ?>Ajax/depajax.php"
                    method="POST"
                    autocomplete="off">
                    <input type="hidden" name="accion"     value="actualizar">
                    <input type="hidden" name="dep_id_upd" id="dep_id_upd">
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">Nombre del Departamento</label>
                        <input type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,20}" class="form-control" name="dep_nombre_upd"
                            id="dep_nombre_upd" maxlength="20" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">Estado</label>
                        <select class="form-select" name="dep_vigente_upd" id="dep_vigente_upd">
                            <option value="1">Vigente</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success btn-sm px-4">
                            <i class="far fa-save"></i> &nbsp; GUARDAR CAMBIOS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-actualizar-dep').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('dep_id_upd').value      = this.dataset.id;
            document.getElementById('dep_nombre_upd').value  = this.dataset.nombre;
            document.getElementById('dep_vigente_upd').value = this.dataset.vigente;
            new bootstrap.Modal(document.getElementById('modalActualizarDep')).show();
        });
    });
    document.querySelectorAll('.btn-eliminar-dep').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id     = this.dataset.id;
            const nombre = this.dataset.nombre;
            Swal.fire({
                title:             '¿Eliminar departamento?',
                text:              'Se eliminará "' + nombre + '". Esta acción no se puede deshacer.',
                icon:              'warning',
                showCancelButton:  true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText:  'Cancelar',
                confirmButtonColor: '#dc3545'
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url:  '<?php echo SERVERURL; ?>Ajax/depajax.php',
                        type: 'POST',
                        data: { accion: 'eliminar', dep_id_del: id },
                        success: function (resp) { alertas_ajax(resp); }
                    });
                }
            });
        });
    });
});
</script>
