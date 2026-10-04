<?php
if(isset($peticionAjax) && $peticionAjax){
    require_once "../modelos/nodoModelo.php";
}else{
    require_once "./modelos/nodoModelo.php";
}

// Cambiamos el extends a main para respetar tu arquitectura MVC fija
class nodoControlador extends main {

    // ──────────────────────────────────────────
    //  PROCESAR HISTORIAL DE EVENTOS (ORION API)
    // ──────────────────────────────────────────
    public function registrar_historial_orion_controlador($nodosOrion) {
        if(!is_array($nodosOrion) || empty($nodosOrion)){
            return false;
        }
        
        foreach ($nodosOrion as $nodo) {
            $nodoId = $nodo['NodeID'] ?? $nodo['Caption'];
            $nombre = $nodo['Caption'];
            $statusActual = $nodo['Status']; // 1 = UP, 2 = DOWN
            
            // 1. REVISAR SI EL EQUIPO YA TIENE UNA CAÍDA ACTIVA (Sin fecha_up)
            $caidaAbierta = nodoModelo::obtener_caida_abierta_modelo($nodoId);

            if ($statusActual == 2) { 
                // EL EQUIPO ESTÁ CAÍDO (DOWN)
                if (!$caidaAbierta) {
                    // Si se acaba de caer y no hay registro abierto -> INSERT
                    nodoModelo::registrar_nueva_caida_modelo($nodoId, $nombre);
                }
            } 
            else if ($statusActual == 1) {
                // EL EQUIPO ESTÁ ACTIVO (UP)
                if ($caidaAbierta) {
                    // Si está activo pero seguía abierto en la BD -> UPDATE (Cierra caída)
                    nodoModelo::cerrar_caida_existente_modelo($caidaAbierta['id']);
                }
            }
        }
        return true;
    }
}