<?php
ob_start();

$peticionAjax = true;
require_once "../config/SERVER.php";

ob_clean();
header('Content-Type: application/json; charset=utf-8');

if(isset($_POST['accion'])){

    require_once "../controladores/depEnControlador.php";
    $depEnl = new depEnlControlador();
    $accion = $_POST['accion'];

    switch($accion){

        case 'cargar_selects':
            echo $depEnl->cargar_selects_controlador();
            break;

        case 'vincular':
            if(isset($_POST['dep_id'], $_POST['enlace_id'])){
                echo $depEnl->vincular_controlador();
            } else {
                echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Datos incompletos!','Texto'=>'No se recibieron los IDs.','Tipo'=>'error']);
            }
            break;
            
        case 'listar_vinculos':
        // Cambiamos el header temporalmente porque esto devuelve HTML, no JSON
        header('Content-Type: text/html; charset=utf-8');
        echo $depEnl->listar_vinculos_controlador();
        break;

        case 'eliminar':
            if(isset($_POST['depEnl_id_del'])){
                echo $depEnl->eliminar_vinculo_controlador();
            } else {
                echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Datos incompletos!','Texto'=>'No se recibió el ID del vínculo.','Tipo'=>'error']);
            }
            break;

// ... resto del switch ...

        default:
            echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Acción inválida!','Texto'=>'La acción solicitada no existe.','Tipo'=>'error']);
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