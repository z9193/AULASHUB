<?php

?>

<div class="container-fluid mb-4">
    <div class="full-box page-header">
        <h3 class="text-left text-uppercase">
            <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR DEPARTAMENTO
        </h3>
        <p class="text-justify text-muted">
            Introduce el nombre del departamento para filtrar la información y consultar su estado actual.
        </p>
    </div>
 
    <div class="container-fluid">
        <ul class="nav nav-tabs nav-justified mb-4 text-uppercase small">
            <li class="nav-item">
                <a class="nav-link text-dark" href="<?php echo SERVERURL; ?>?views=departamentos">
                    <i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR DEPARTAMENTO
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="<?php echo SERVERURL; ?>?views=departamentos-lista">
                    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE DEPARTAMENTOS
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active text-danger fw-bold" href="<?php echo SERVERURL; ?>?views=departamentos-buscar">
                    <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR DEPARTAMENTO
                </a>
            </li>
        </ul>
    </div>
 
    <!-- Formulario de búsqueda -->
    <div class="container-fluid mb-4">
        <form class="FormularioAjax form-neon shadow-sm p-4 bg-white border"
            action="<?php echo SERVERURL; ?>Ajax/depajax.php"
            method="POST"
            autocomplete="off">
 
            <input type="hidden" name="accion" value="buscar">
 
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-6">
                    <div class="form-group mb-3 text-center">
                        <label class="form-label fw-bold text-uppercase small">¿Qué departamento buscas?</label>
                        <input type="text"
                            class="form-control form-control-sm text-center"
                            placeholder="Escribe el nombre..."
                            name="busqueda_inicial"
                            value="<?php echo isset($_SESSION['busqueda_departamento'])
                                        ? htmlspecialchars($_SESSION['busqueda_departamento'])
                                        : ''; ?>"
                            required>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary btn-sm px-4 shadow-sm">
                        <i class="fas fa-search"></i> &nbsp; BUSCAR
                    </button>
                </div>
            </div>
        </form>
    </div>
 
    <!-- Tabla de resultados -->
    <div class="container-fluid">
        <div class="table-responsive shadow-sm bg-white p-3 border">
            <table class="table table-hover table-bordered align-middle table-sm">
                <thead class="bg-dark text-white text-uppercase">
                    <tr class="text-center small">
                        <th>#</th>
                        <th>CÓDIGO</th>
                        <th>NOMBRE</th>
                        <th>ESTADO</th>
                        <th>INFO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $filas; ?>
                </tbody>
            </table>
        </div>

        <?php echo $paginador; ?>
    </div>
</div>
