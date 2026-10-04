<?php
    // Lógica para inicializar el controlador y obtener los datos
    require_once "./controladores/diControlador.php";
    $ins_dispositivo = new diControlador();

    // Obtener el número de página de la URL
    $pagina = explode("/", $_GET['views']);
    $pagina_actual = (isset($pagina[1]) && is_numeric($pagina[1])) ? (int)$pagina[1] : 1;

    // Llamar al controlador para obtener filas y paginador
    $datos = $ins_dispositivo->paginador_dispositivo_controlador($pagina_actual, "lista");
    $datos = explode("|||", $datos);

    $filas = $datos[0];
    $paginador = $datos[1];
?>

<div class="container-fluid mb-4">
    <div class="full-box page-header">
        <h3 class="text-left text-uppercase">
            <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE DISPOSITIVOS
        </h3>
        <p class="text-justify text-muted">
            Administra los enlaces registrados en el sistema. Puedes ver detalles, editar o eliminar registros.
        </p>
    </div>

    <div class="container-fluid">
        <ul class="nav nav-tabs nav-justified mb-4 text-uppercase">
            <li class="nav-item">
                <a class="nav-link text-dark" href="<?php echo SERVERURL; ?>dispositivos/">
                    <i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR DISPOSITIVO</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active text-danger fw-bold" href="<?php echo SERVERURL; ?>dispositivo-lista/">
                    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE DISPOSITIVOS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="<?php echo SERVERURL; ?>dispositivo-buscar/">
                    <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR DISPOSITIVO</a>
            </li>
        </ul>
    </div>

    <div class="container-fluid">
        <div class="table-responsive shadow-sm bg-white p-3 border">
            <table class="table table-hover table-bordered align-middle table-sm">
                <thead class="bg-light">
                    <tr class="text-center fw-bold">
                        <th>#</th>
                        <th>ID</th> 
                        <th>NOMBRE</th> 
                        <th>ESTADO</th>
                        <th>ACTUALIZAR</th>
                        <th>ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $filas; ?>
                </tbody>
            </table>
            
            <div class="mt-3 text-center">
                <?php echo $paginador; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalActualizarEn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-sync-alt"></i> &nbsp; Actualizar Dispositivo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form class="FormularioAjax"
                    action="<?php echo SERVERURL; ?>Ajax/dispositivoajax.php"
                    method="POST"
                    autocomplete="off">
                    <input type="hidden" name="accion" value="actualizar">
                    <input type="hidden" name="di_id_upd" id="di_id_upd">
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">Nombre del Dispositivo</label>
                        <input type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,20}" class="form-control" name="di_nombre_upd"
                            id="di_nombre_upd" maxlength="20" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold">Estado</label>
                        <select class="form-select" name="di_vigente_upd" id="di_vigente_upd">
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
    // Abrir Modal y cargar datos
    document.querySelectorAll('.btn-actualizar-en').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('di_id_upd').value      = this.dataset.id;
            document.getElementById('di_nombre_upd').value  = this.dataset.nombre;
            document.getElementById('di_vigente_upd').value = this.dataset.vigente;
            new bootstrap.Modal(document.getElementById('modalActualizarEn')).show();
        });
    });

    
    document.querySelectorAll('.btn-eliminar-en').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id     = this.dataset.id;
            const nombre = this.dataset.nombre;
            Swal.fire({
                title:             '¿Eliminar enlace?',
                text:              'Se eliminará "' + nombre + '". Esta acción no se puede deshacer.',
                icon:              'warning',
                showCancelButton:  true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText:  'Cancelar',
                confirmButtonColor: '#dc3545'
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url:  '<?php echo SERVERURL; ?>Ajax/dispositivoajax.php',
                        type: 'POST',
                        data: { accion: 'eliminar', di_id_del: id },
                        success: function (resp) { 
                            alertas_ajax(resp); 
                        }
                    });
                }
            });
        });
    });
});
</script>