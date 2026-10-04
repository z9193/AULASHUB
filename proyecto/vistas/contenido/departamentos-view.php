<div class="container-fluid mb-4">
    <div class="full-box page-header">
        <h3 class="text-left text-uppercase">
            <i class="fas fa-building fa-fw"></i> &nbsp; NUEVO DEPARTAMENTO
        </h3>
        <p class="text-justify text-muted">
            En este módulo podrás registrar nuevos departamentos en el sistema para organizar mejor los dispositivos y enlaces de red.
        </p>
    </div>

    <div class="container-fluid">
        <ul class="nav nav-tabs nav-justified mb-4">
            <li class="nav-item">
                <a class="nav-link active text-primary" href="<?php echo SERVERURL; ?>departamentos/">
                    <i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR DEPARTAMENTO</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="<?php echo SERVERURL; ?>departamentos-lista/">
                    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE DEPARTAMENTOS
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="<?php echo SERVERURL; ?>departamentos-buscar/">
                    <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR DEPARTAMENTO</a>
            </li>
        </ul>
    </div>

    <div class="container-fluid">
        <form class="FormularioAjax form-neon shadow p-4 bg-white border" action="<?php echo SERVERURL; ?>Ajax/depajax.php" method="POST" data-form="save" autocomplete="off">
            
            <input type="hidden" name="accion" value="agregar">

            <fieldset>
                <legend><i class="far fa-address-card"></i> &nbsp; Información del Departamento</legend>
                <div class="container-fluid mt-3">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label for="dep_nombre" class="form-label fw-bold">Nombre del Departamento</label>
                                <input type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,20}" class="form-control" name="dep_nombre_reg" id="dep_nombre" maxlength="20" required>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-3">
                                <label for="dep_vigente" class="form-label fw-bold">Estado</label>
                                <input type="text" class="form-control" value="VIGENTE" readonly>
                                <input type="hidden" name="dep_vig_reg" value="1">
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