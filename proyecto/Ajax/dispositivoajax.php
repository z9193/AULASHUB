<?php
// ── Capturar TODO output desde el primer byte ─────────────────
ob_start();

$peticionAjax = true;
require_once "../config/main.php";
require_once "../config/configGen.php";

// ── Limpiar cualquier output acumulado y forzar cabecera JSON ──
ob_clean();
header('Content-Type: application/json; charset=utf-8');

if(isset($_POST['accion'])){

    require_once "../controladores/diControlador.php";
    
    // CAMBIO CLAVE: El nombre de la variable debe coincidir con el del switch
    $di = new diControlador(); 
    $accion = main::limpiar_cadena($_POST['accion']);

    switch($accion){

        case 'buscar':
            if(isset($_POST['busqueda_inicial'])){
                echo $di->buscar_dispositivo_controlador();
            } else {
                echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Datos incompletos!','Texto'=>'No se recibió el término de búsqueda.','Tipo'=>'error']);
            }
            break;

        case 'agregar':
            if(isset($_POST['di_nombre_reg'])){
                echo $di->agregar_dispositivo_controlador();
            } else {
                echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Datos incompletos!','Texto'=>'No se recibieron los datos para registrar el dispositivo.','Tipo'=>'error']);
            }
            break;

        case 'eliminar':
            if(isset($_POST['di_id_del'])){
                echo $di->eliminar_dispositivo_controlador();
            } else {
                echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Datos incompletos!','Texto'=>'No se recibió el ID del dispositivo.','Tipo'=>'error']);
            }
            break;

        case 'actualizar':
            if(isset($_POST['di_id_upd'], $_POST['di_nombre_upd'], $_POST['di_vigente_upd'])){
                echo $di->actualizar_dispositivo_controlador();
            } else {
                echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Datos incompletos!','Texto'=>'No se recibieron todos los campos para actualizar el enlace.','Tipo'=>'error']);
            }
            break;

        default:
            echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Acción inválida!','Tipo'=>'error']);
            break;
    }

} else {
    if(session_status() === PHP_SESSION_NONE){
        session_start(['name' => 'SPM']);
    }
    session_unset();
    session_destroy();
    echo json_encode(['Alerta'=>'redireccionar','URL'=> SERVERURL . 'login/']);
}

// ── Enviar el buffer limpio ────────────────────────────────────
ob_end_flush();