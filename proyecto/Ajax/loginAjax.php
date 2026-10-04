<?php
    $peticionAjax = true;

    // Tienes que cargar la configuración PRIMERO para que SERVERURL exista
    require_once "../config/configGen.php"; 
    require_once "../controladores/ControladorUsuario.php";

    $insUsuario = new ControladorUsuario();

    if(isset($_POST['numero_empleado'])){
        // El controlador ahora sí encontrará la constante SERVERURL cuando la necesite
        echo $insUsuario->iniciar_sesion_controlador();
    } else {
        // Por seguridad, si entran directo al archivo, mándalos al login
        header("Location: ".SERVERURL."login/");
        exit();
    }
