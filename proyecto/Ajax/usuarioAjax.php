<?php
    $peticionAjax = true;
    require_once "../config/main.php";
    require_once "../config/configGen.php";

    header('Content-Type: application/json; charset=utf-8');

    if(isset($_POST['accion'])){

        require_once "../controladores/ControladorUsuario.php";
        $usr    = new ControladorUsuario();
        $accion = main::limpiar_cadena($_POST['accion']);

        switch($accion){

            // ── AGREGAR ──────────────────────────
            case 'agregar':
                if(isset($_POST['usuario_nombre_reg'], $_POST['usuario_primer_apellido_reg'],
                $_POST['usuario_numero_empleado_reg'], $_POST['usuario_contraseña_reg'])){
                    $usr->agregar_usuario_controlador();
                } else {
                    echo json_encode([
                        'Alerta' => 'simple',
                        'Titulo' => '¡Datos incompletos!',
                        'Texto'  => 'No se recibieron todos los campos requeridos.',
                        'Tipo'   => 'error'
                    ]);
                }
                break;

            // ── ELIMINAR ─────────────────────────
            case 'eliminar':
                if(isset($_POST['usuario_id_del'])){
                    $usr->eliminar_usuario_controlador();
                } else {
                    echo json_encode([
                        'Alerta' => 'simple',
                        'Titulo' => '¡Datos incompletos!',
                        'Texto'  => 'No se recibió el ID del usuario.',
                        'Tipo'   => 'error'
                    ]);
                }
                break;

            // ── ACCIÓN NO RECONOCIDA ─────────────
            default:
                echo json_encode([
                    'Alerta' => 'simple',
                    'Titulo' => '¡Acción inválida!',
                    'Texto'  => 'La acción solicitada no está disponible.',
                    'Tipo'   => 'error'
                ]);
                break;
        }

    } else {
        session_start(['name' => 'SPM']);
        session_unset();
        session_destroy();
        header("Location: " . SERVERURL . "login/");
        exit();
    }
?>