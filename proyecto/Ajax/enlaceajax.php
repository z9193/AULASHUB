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

    require_once "../controladores/enControlador.php";
    
    // CAMBIO CLAVE: El nombre de la variable debe coincidir con el del switch
    $en = new enControlador(); 
    $accion = main::limpiar_cadena($_POST['accion']);

    switch($accion){

        case 'buscar':
            if(isset($_POST['busqueda_inicial'])){
                echo $en->buscar_enlace_controlador();
            } else {
                echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Datos incompletos!','Texto'=>'No se recibió el término de búsqueda.','Tipo'=>'error']);
            }
            break;

        case 'agregar':
            if(isset($_POST['en_nombre_reg'])){
                echo $en->agregar_enlace_controlador();
            } else {
                echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Datos incompletos!','Texto'=>'No se recibieron los datos para registrar el enlace.','Tipo'=>'error']);
            }
            break;

        case 'eliminar':
            if(isset($_POST['en_id_del'])){
                echo $en->eliminar_enlace_controlador();
            } else {
                echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Datos incompletos!','Texto'=>'No se recibió el ID del enlace.','Tipo'=>'error']);
            }
            break;

        case 'actualizar':
            if(isset($_POST['en_id_upd'], $_POST['en_nombre_upd'], $_POST['en_vigente_upd'])){
                echo $en->actualizar_enlace_controlador();
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