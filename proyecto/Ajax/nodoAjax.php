<?php
set_time_limit(0); 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Capturar cualquier error fatal oculto y forzarlo a ser JSON
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
        if (ob_get_length()) ob_clean();
        echo json_encode([
            "status" => "error", 
            "message" => "Error crítico de PHP: " . $error['message'] . " en " . $error['file'] . " línea " . $error['line']
        ]);
        exit;
    }
});

$ip_orion = "148.229.3.232"; 
$user     = "monitor";
$pass     = 'M965xxn0';

$url = "https://$ip_orion:17778/SolarWinds/InformationService/v3/Json/Query?query=SELECT+NodeID,Caption,IPAddress,Status+FROM+Orion.Nodes";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL             => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_USERPWD        => "$user:$pass",
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_TIMEOUT        => 20,
    CURLOPT_CONNECTTIMEOUT => 30,
    CURLOPT_SSLVERSION     => CURL_SSLVERSION_TLSv1_2,
    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
    CURLOPT_SSL_CIPHER_LIST => 'AES128-SHA:AES256-SHA:AES128-SHA256:AES256-SHA256:ECDHE-RSA-AES128-SHA:ECDHE-RSA-AES256-SHA',
    CURLOPT_HTTPHEADER     => [
        "Accept: application/json",
        "Expect:",
        "User-Agent: curl/7.55.1"
    ],
]);

$response = curl_exec($ch);
$error    = curl_error($ch);
curl_close($ch);

if (ob_get_length()) ob_clean();

if ($response === false) {
    echo json_encode(["status" => "error", "message" => "Error de cURL: " . $error]);
    exit;
}

$data = json_decode($response, true);

if (isset($data['results']) && !empty($data['results'])) {
    
    // 🛡️ CORRECCIÓN DE RUTA: Usamos __DIR__ para asegurar que encuentre el archivo siempre
    $rutaControlador = __DIR__ . "/../controladores/nodoControlador.php";
    
    if (file_exists($rutaControlador)) {
        $peticionAjax = true;
        require_once $rutaControlador;

        // Verificar si la clase existe antes de instanciarla
        if (class_exists('nodoControlador')) {
            $insControlador = new nodoControlador();
            $insControlador->registrar_historial_orion_controlador($data['results']);
        } else {
            echo json_encode(["status" => "error", "message" => "La clase nodoControlador no existe."]);
            exit;
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No se encontró el archivo controlador en: " . $rutaControlador]);
        exit;
    }
}

// Retornar la respuesta original de SolarWinds
echo $response;
exit;