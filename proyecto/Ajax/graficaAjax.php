<?php
$peticionAjax = true;
header("Content-Type: application/json; charset=UTF-8");

require_once "../modelos/nodoModelo.php";

$nivel = isset($_GET['nivel']) ? trim($_GET['nivel']) : 'nodo';
$mes   = isset($_GET['mes'])   ? (int)trim($_GET['mes'])   : 0;
$dia   = isset($_GET['dia'])   ? (int)trim($_GET['dia'])   : 0;

switch($nivel) {
    case 'mes':
        $datos = nodoModelo::caidas_por_mes();
        break;
    case 'dia':
        if($mes > 0) {
            $datos = nodoModelo::caidas_por_dia($mes);
        } else {
            $datos = ["error" => "Falta parámetro: mes"];
        }
        break;
    case 'nodo':
    case 'equipo':
        if($mes > 0 && $dia > 0) {
            $datos = nodoModelo::caidas_por_nodo_dia($mes, $dia);
        } else {
            $datos = nodoModelo::caidas_por_nodo();
        }
        break;
    default:
        $datos = nodoModelo::caidas_por_nodo();
}

echo json_encode($datos, JSON_UNESCAPED_UNICODE);
exit();