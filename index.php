<?php

require_once __DIR__ . '/models/Aula.php';
require_once __DIR__ . '/models/Reserva.php';
require_once __DIR__ . '/controllers/AulaController.php';

$controller = new AulaController();
$action = $_GET['action'] ?? 'login';

if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    http_response_code(404);
    echo 'Página no encontrada';
}
