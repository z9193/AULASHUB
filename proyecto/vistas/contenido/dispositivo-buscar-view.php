<?php
    // Iniciar sesión para acceder a las búsquedas guardadas y evitar errores de sesión
    if(session_status() === PHP_SESSION_NONE){
        session_start(['name' => 'SPM']);
    }

    require_once "./controladores/diControlador.php";
    $ins_dispositivo = new diControlador();

    // 1. Procesar la búsqueda inicial si se envía el formulario
    if(isset($_POST['busqueda_inicial'])){
        $ins_dispositivo->buscar_dispositivo_controlador();
    }

    // 2. Manejar la eliminación de la búsqueda para limpiar la vista
    if(isset($_POST['eliminar_busqueda'])){
        unset($_SESSION['busqueda_dispositivo']);
        header("Location: ".SERVERURL."dispositivo-buscar/");
        exit();
    }

    // 3. Configurar la paginación y obtener resultados
    $pagina = explode("/", $_GET['views']);
    $pagina_actual = (isset($pagina[1]) && is_numeric($pagina[1])) ? (int)$pagina[1] : 1;

    // Llamamos al controlador en modo 'buscar' para que use el término de la sesión
    $datos = $ins_dispositivo->paginador_dispositivo_controlador($pagina_actual, "buscar");
    $datos = explode("|||", $datos); // Separamos filas del paginador

    $filas = $datos[0];
    $paginador = $datos[1];
?>

<div class="container-fluid mb-4">
    <div class="full-box page-header">
        <h3 class="text-left text-uppercase">
            <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR DISPOSITIVO
        </h3>
        <p class="text-justify text-muted">
            Introduce el nombre del enlace para filtrar la información y consultar su estado actual.
        </p>
    </div>

    <div class="container-fluid">
        <ul class="nav nav-tabs nav-justified mb-4 text-uppercase small">
            <li class="nav-item">
                <a class="nav-link text-dark" href="<?php echo SERVERURL; ?>dispositivos/">
                    <i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR DISPOSITIVO
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="<?php echo SERVERURL; ?>dispositivo-lista/">
                    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE DISPOSITIVOS
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active text-danger fw-bold" href="<?php echo SERVERURL; ?>dispositivo-buscar/">
                    <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR DISPOSITIVO
                </a>
            </li>
        </ul>
    </div>

    <div class="container-fluid mb-4">
        <?php if(!isset($_SESSION['busqueda_dispositivo']) || $_SESSION['busqueda_dispositivo'] == ""){ ?>
            <form class="FormularioAjax form-neon shadow-sm p-4 bg-white border"
                action="<?php echo SERVERURL; ?>Ajax/dispositivoajax.php"
                method="POST"
                data-form="default"
                autocomplete="off"> 
                <input type="hidden" name="accion" value="buscar">

                <div class="row justify-content-md-center">
                    <div class="col-12 col-md-6">
                        <div class="form-group mb-3 text-center">
                            <label class="form-label fw-bold text-uppercase small">¿Qué dispositivo buscas?</label>
                            <input type="text"
                                class="form-control form-control-sm text-center"
                                placeholder="Escribe el nombre..."
                                name="busqueda_inicial"
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
        <?php } else { ?>
            <form class="FormularioAjax text-center shadow-sm p-4 bg-white border" 
                action="<?php echo SERVERURL; ?>Ajax/dispositivoajax.php" 
                method="POST" data-form="search">
                <input type="hidden" name="eliminar_busqueda" value="1">
                <input type="hidden" name="accion" value="buscar">
                <p class="mb-3">Estás buscando: <strong>“<?php echo htmlspecialchars($_SESSION['busqueda_dispositivo']); ?>”</strong></p>
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA
                </button>
            </form>
        <?php } ?>
    </div>

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
        
        <div class="mt-3 text-center">
            <?php echo $paginador; ?>
        </div>
    </div>
</div>