<!-- 
    registro-view.php
    Vista para registrar nuevos usuarios.
    Requiere: ControladorUsuario → agregar_usuario_controlador()
    Ajax:     Ajax/usuarioAjax.php  accion=agregar
-->
<div class="container-fluid mb-4">

    <div class="full-box page-header">
        <h3 class="text-left text-uppercase">
            <i class="fas fa-user-plus fa-fw"></i> &nbsp; REGISTRAR USUARIO
        </h3>
        <p class="text-justify text-muted">
            Completa el formulario para agregar un nuevo usuario al sistema.
        </p>
    </div>

    <div class="container-fluid">
        <ul class="nav nav-tabs nav-justified mb-4 text-uppercase small">
            <li class="nav-item">
                <a class="nav-link active text-primary fw-bold" href="<?php echo SERVERURL; ?>?views=registro">
                    <i class="fas fa-user-plus fa-fw"></i> &nbsp; REGISTRAR USUARIO
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="<?php echo SERVERURL; ?>?views=usuarios-lista">
                    <i class="fas fa-users fa-fw"></i> &nbsp; LISTA DE USUARIOS
                </a>
            </li>
        </ul>
    </div>

    <div class="container-fluid">
        <form class="FormularioAjax form-neon shadow p-4 bg-white border"
              action="<?php echo SERVERURL; ?>Ajax/usuarioAjax.php"
              method="POST"
              autocomplete="off">

            <input type="hidden" name="accion" value="agregar">

            <fieldset>
                <legend><i class="far fa-address-card"></i> &nbsp; Datos del Usuario</legend>

                <div class="container-fluid mt-3">
                    <div class="row">

                        <!-- Nombre -->
                        <div class="col-12 col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">
                                    Nombre <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control"
                                       name="usuario_nombre_reg"
                                       placeholder="Ej: Juan"
                                       pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,20}"
                                       maxlength="20"
                                       required>
                            </div>
                        </div>

                        <!-- Primer Apellido -->
                        <div class="col-12 col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">
                                    Primer Apellido <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control"
                                       name="usuario_primer_apellido_reg"
                                       placeholder="Ej: García"
                                       pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,20}"
                                       maxlength="20"
                                       required>
                            </div>
                        </div>

                        <!-- Segundo Apellido -->
                        <div class="col-12 col-md-4">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Segundo Apellido</label>
                                <input type="text"
                                       class="form-control"
                                       name="usuario_segundo_apellido_reg"
                                       placeholder="Ej: López (opcional)"
                                       pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,20}"
                                       maxlength="20">
                            </div>
                        </div>

                        <!-- Número de Empleado -->
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">
                                    Número de Empleado <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control"
                                       name="usuario_numero_empleado_reg"
                                       placeholder="Ej: EMP001"
                                       pattern="[a-zA-Z0-9]{1,35}"
                                       maxlength="35"
                                       required>
                                <small class="text-muted">Solo letras y números, sin espacios.</small>
                            </div>
                        </div>

                        <!-- Contraseña -->
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">
                                    Contraseña <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password"
                                           class="form-control"
                                           name="usuario_contraseña_reg"
                                           id="inputContraseña"
                                           placeholder="Mínimo 5 caracteres"
                                           minlength="5"
                                           maxlength="30"
                                           required>
                                    <button type="button"
                                            class="btn btn-outline-secondary"
                                            id="btnVerClave"
                                            title="Mostrar/ocultar contraseña">
                                        <i class="fas fa-eye" id="iconoClave"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div><!-- /row -->
                </div>
            </fieldset>

            <p class="text-center mt-4">
                <button type="reset" class="btn btn-secondary btn-sm">
                    <i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR
                </button>
                &nbsp;&nbsp;
                <button type="submit" class="btn btn-info btn-sm text-white">
                    <i class="far fa-save"></i> &nbsp; REGISTRAR USUARIO
                </button>
            </p>

        </form>
    </div>
</div>

<script>
// Mostrar / ocultar contraseña
document.getElementById('btnVerClave').addEventListener('click', function(){
    var input = document.getElementById('inputContraseña');
    var icono = document.getElementById('iconoClave');
    if(input.type === 'password'){
        input.type = 'text';
        icono.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icono.classList.replace('fa-eye-slash', 'fa-eye');
    }
});
</script>