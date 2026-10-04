<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit(); // Siempre pon exit después de un header para que no siga cargando
}

$grupo = $_POST['grupo'] ?? ''; 
$seccion = $_POST['seccion'] ?? ''; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

<header class="navbar bg-dark shadow">
    <span class="navbar-brand ms-3 text-white">Proyecto</span>
</header>

<div class="d-flex">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width:280px; height:100vh;">
        <a href="#" class="text-secondary text-decoration-none text-uppercase" onclick="enviarParametros('', '')">INICIO</a>
        <hr>
        <div id="contenedor-menu">
            <div class="accordion accordion-flush" id="menuLateral">
                <div class="accordion-item bg-transparent border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-transparent text-white shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#sub-catalogos">Catalogos</button>
                    </h2>
                    <div id="sub-catalogos" class="accordion-collapse collapse" data-bs-parent="#menuLateral">
                        <div class="accordion-body p-0 ps-3">
                            <ul class="list-unstyled">
                                <li><a href="#" class="text-white-50 d-block py-2" onclick="enviarParametros('Catalogos', 'Departamentos')">Departamentos</a></li>
                                <li><a href="#" class="text-white-50 d-block py-2" onclick="enviarParametros('Catalogos', 'Enlaces')">Enlaces</a></li>
                                <li><a href="#" class="text-white-50 d-block py-2" onclick="enviarParametros('Catalogos', 'Dispositivos')">Dispositivos</a></li>
                                <li><a href="#" class="text-white-50 d-block py-2" onclick="enviarParametros('Catalogos', 'Dep-Enlaces')">Departamento-Enlace</a></li>
                                <li><a href="#" class="text-white-50 d-block py-2" onclick="enviarParametros('Catalogos', 'Dep-Dispositivos')">Departamento-Dispositivo</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-auto p-3 border-top border-secondary">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <strong><?php echo $_SESSION['nombre'] ?? 'Usuario'; ?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div id="contenido-principal" class="p-4 w-100">
        <?php 
        $nuevoContenido = "../vistas/" . strtolower($seccion) . ".php";

        if ($seccion != "" && file_exists($nuevoContenido)) {
            include $nuevoContenido;
        } else {
            ?>
            <h1 class="text-dark">Holi</h1>
            <p>.</p>
            <?php 
        } 
        ?>
    </div>
</div>

<script>

    function enviarParametros(grupo, seccion) {
    $.post('principal.php', { grupo: grupo, seccion: seccion }, function(data) {
        var nuevoContenido = $(data).find('#contenido-principal').html();
        $('#contenido-principal').html(nuevoContenido);
        
    });
}

</script>

</body>
</html>