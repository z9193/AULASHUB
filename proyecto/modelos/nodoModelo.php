<?php
if(isset($peticionAjax) && $peticionAjax){
    require_once "../config/main.php";
} else {
    require_once "./config/main.php";
}

class nodoModelo extends main {

    public static function obtener_caida_abierta_modelo($nodoId) {
        $sql = main::conectar()->prepare("
            SELECT id FROM historial_caidas 
            WHERE nodo_id = :NodoID AND fecha_up IS NULL 
            LIMIT 1
        ");
        $sql->bindParam(":NodoID", $nodoId);
        $sql->execute();
        return $sql->fetch();
    }

    public static function registrar_nueva_caida_modelo($nodoId, $nombre) {
        $sql = main::conectar()->prepare("
            INSERT INTO historial_caidas(nodo_id, nombre_equipo, fecha_down) 
            VALUES(:NodoID, :Nombre, NOW())
        ");
        $sql->bindParam(":NodoID", $nodoId);
        $sql->bindParam(":Nombre", $nombre);
        $sql->execute();
        return $sql;
    }

    public static function cerrar_caida_existente_modelo($id) {
        $sql = main::conectar()->prepare("
            UPDATE historial_caidas 
            SET fecha_up = NOW(), 
                tiempo_caido_minutos = TIMESTAMPDIFF(MINUTE, fecha_down, NOW()) 
            WHERE id = :ID
        ");
        $sql->bindParam(":ID", $id);
        $sql->execute();
        return $sql;
    }

    // Nivel 1: top equipos con más tiempo caído (Cálculo en vivo si está en NULL)
    public static function caidas_por_nodo() {
        $sql = main::conectar()->prepare("
            SELECT 
                nombre_equipo AS label,
                SUM(IFNULL(tiempo_caido_minutos, TIMESTAMPDIFF(MINUTE, fecha_down, NOW()))) AS total_minutos
            FROM historial_caidas
            WHERE nombre_equipo IS NOT NULL
                AND fecha_down IS NOT NULL
            GROUP BY nombre_equipo
            ORDER BY total_minutos DESC
        ");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nivel 1 alt: agrupado por mes (Cálculo en vivo si está en NULL)
    public static function caidas_por_mes() {
        $sql = main::conectar()->prepare("
            SELECT 
                MONTH(fecha_down) AS label,
                SUM(IFNULL(tiempo_caido_minutos, TIMESTAMPDIFF(MINUTE, fecha_down, NOW()))) AS total_minutos
            FROM historial_caidas
            WHERE fecha_down IS NOT NULL
            GROUP BY MONTH(fecha_down)
            ORDER BY MONTH(fecha_down) ASC
        ");
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nivel 2: días dentro de un mes (Cálculo en vivo si está en NULL)
    public static function caidas_por_dia($mesNumero) {
        $sql = main::conectar()->prepare("
            SELECT 
                DAY(fecha_down) AS label,
                SUM(IFNULL(tiempo_caido_minutos, TIMESTAMPDIFF(MINUTE, fecha_down, NOW()))) AS total_minutos
            FROM historial_caidas
            WHERE MONTH(fecha_down) = :MesNumero
                AND fecha_down IS NOT NULL
            GROUP BY DAY(fecha_down)
            ORDER BY DAY(fecha_down) ASC
        ");
        $sql->bindParam(":MesNumero", $mesNumero, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nivel 3: equipos caídos en un día específico (Cálculo en vivo si está en NULL)
    public static function caidas_por_nodo_dia($mesNumero, $diaNumero) {
        $sql = main::conectar()->prepare("
            SELECT 
                nombre_equipo AS label,
                SUM(IFNULL(tiempo_caido_minutos, TIMESTAMPDIFF(MINUTE, fecha_down, NOW()))) AS total_minutos
            FROM historial_caidas
            WHERE MONTH(fecha_down) = :MesNumero
                AND DAY(fecha_down)   = :DiaNumero
                AND fecha_down IS NOT NULL
            GROUP BY nombre_equipo
            ORDER BY total_minutos DESC
        ");
        $sql->bindParam(":MesNumero", $mesNumero, PDO::PARAM_INT);
        $sql->bindParam(":DiaNumero", $diaNumero, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}