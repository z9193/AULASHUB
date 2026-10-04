<?php 
    /* 1. Definir el nombre de la sesión ANTES de iniciarla */
    session_name("SPM"); 
    if(session_status() == PHP_SESSION_NONE){ 
        session_start(); 
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Proyecto</title>
    <?php include "./vistas/inc/links.php"; ?>
</head>

<body>
    <?php
        $peticionAjax = false;
        require_once "./controladores/vistasC.php";
        $vt     = new vistasC();
        $vistas = $vt->obtvistas();

        if($vistas == "login" || $vistas == "404"){
            require_once "./vistas/contenido/".$vistas."-view.php";
        } 
        else {
            /* 2. Control de seguridad (Opcional pero recomendado) */
            // Si alguien intenta entrar a una vista sin loguearse, lo mandamos al login
            if(!isset($_SESSION['nombre'])){
                echo "<script> window.location.href='".SERVERURL."login/'; </script>";
                exit();
            }

            $url    = isset($_GET["views"]) ? explode("/", $_GET["views"]) : [];
            $numPag = isset($url[1]) ? (int)$url[1] : 1;

            if($vistas === "./vistas/contenido/departamentos-lista-view.php"){
                require_once "./controladores/depControlador.php";
                $depCon = new depControlador();
                [$filas, $paginador] = explode('|||',
                    $depCon->paginador_departamento_controlador($numPag, 'lista')
                );
            }

            if($vistas === "./vistas/contenido/departamentos-buscar-view.php"){
                require_once "./controladores/depControlador.php";
                $depCon = new depControlador();
                [$filas, $paginador] = explode('|||',
                    $depCon->paginador_departamento_controlador($numPag, 'buscar')
                );
            }
            ?>

            <main class="full-box main-container">
                <?php include "./vistas/inc/navlateral.php"; ?>
                
                <section style="margin-left: 280px; padding: 20px;">
                    <?php include $vistas; ?>
                </section>
            </main>

        <?php } 
        include "./vistas/inc/script.php"; 
    ?>
</body>
</html>