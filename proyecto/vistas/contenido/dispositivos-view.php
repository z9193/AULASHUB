<div class="container-fluid mb-4">
    <div class="full-box page-header">
        <h3 class="text-left text-uppercase">
            <i class="fas fa-link fa-fw"></i> &nbsp; NUEVO DISPOSITIVO
        </h3>
        <p class="text-justify text-muted">
            En este módulo podrás registrar nuevos enlaces en el sistema para organizar mejor los dispositivos.
        </p>
    </div>

    <div class="container-fluid">
        <ul class="nav nav-tabs nav-justified mb-4">
            <li class="nav-item">
                <a class="nav-link active text-primary" href="<?php echo SERVERURL; ?>dispositivo/">
                    <i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR DISPOSITIVO</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="<?php echo SERVERURL; ?>dispositivo-lista/">
                    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE DISPOSITIVOS
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="<?php echo SERVERURL; ?>dispositivo-buscar/">
                    <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR DISPOSITIVO</a>
            </li>
        </ul>
    </div>

    <div class="container-fluid">
        <form class="FormularioAjax form-neon shadow p-4 bg-white border" action="<?php echo SERVERURL; ?>Ajax/dispositivoajax.php" method="POST" data-form="save" autocomplete="off">

            <input type="hidden" name="accion" value="agregar">

            <fieldset>
                <legend><i class="far fa-address-card"></i> &nbsp; Información del Dispositivo</legend>
                <div class="container-fluid mt-3">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label for="di_nombre" class="form-label fw-bold">Nombre del Dispositivo</label>
                                <input type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,20}" class="form-control" name="di_nombre_reg" id="di_nombre" maxlength="20" required>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label for="di_vigente" class="form-label fw-bold">Vigente</label>
                                <input type="text" class="form-control" value="VIGENTE" readonly>
                                <input type="hidden" name="di_vigente_reg" value="1">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <p class="text-center mt-4">
                <button type="reset" class="btn btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
                &nbsp; &nbsp;
                <button type="submit" class="btn btn-info btn-sm text-white"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
            </p>
        </form>
    </div>
</div>