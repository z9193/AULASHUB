<?php
ob_start();

$peticionAjax = true;
require_once "../config/SERVER.php";

ob_clean();
header('Content-Type: application/json; charset=utf-8');

if(isset($_POST['accion'])){

    require_once "../controladores/depControlador.php";
    $dep    = new depControlador();
    $accion = $_POST['accion'];

    switch($accion){

        case 'buscar':
            if(isset($_POST['busqueda_inicial'])){
                echo $dep->buscar_departamento_controlador();  // ← un solo echo aquí
            } else {
                echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Datos incompletos!','Texto'=>'No se recibió el término de búsqueda.','Tipo'=>'error']);
            }
            break;

        case 'agregar':
            if(isset($_POST['dep_nombre_reg'])){
                echo $dep->agregar_departamento_controlador();
            } else {
                echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Datos incompletos!','Texto'=>'No se recibieron los datos para registrar.','Tipo'=>'error']);
            }
            break;

        case 'eliminar':
            if(isset($_POST['dep_id_del'])){
                echo $dep->eliminar_departamento_controlador();
            } else {
                echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Datos incompletos!','Texto'=>'No se recibió el ID del departamento.','Tipo'=>'error']);
            }
            break;

        case 'actualizar':
            // ← se agrega dep_vigente_upd a la verificación
            if(isset($_POST['dep_id_upd'], $_POST['dep_nombre_upd'], $_POST['dep_vigente_upd'])){
                echo $dep->actualizar_departamento_controlador();
            } else {
                echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Datos incompletos!','Texto'=>'No se recibieron todos los campos para actualizar.','Tipo'=>'error']);
            }
            break;

        default:
            echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Acción inválida!','Texto'=>'La acción solicitada no está disponible.','Tipo'=>'error']);
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

ob_end_flush();