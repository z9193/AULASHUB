<?php
if(isset($peticionAjax) && $peticionAjax){
    require_once "../config/main.php";
}else{
    require_once "./config/main.php";
}

class diModelo extends main{

 /*--- Función para contar registros (para el paginador) ---*/
        protected static function contar_dispositivo_modelo($busqueda){
            $query = "SELECT COUNT(IdDispositivo) FROM catcdispositivos";
            
            // Si hay una búsqueda, filtramos
            if($busqueda != ""){
                $query .= " WHERE Nombre LIKE '%$busqueda%'";
            }

            $sql = main::conectar()->prepare($query);
            $sql->execute();
            return $sql->fetchColumn();
        }

        /*--- Función para listar los registros con límite y offset ---*/
        protected static function listar_dispositivo_modelo($limite, $offset, $busqueda){
            $query = "SELECT * FROM catcdispositivos";

            if($busqueda != ""){
                $query .= " WHERE Nombre LIKE '%$busqueda%'";
            }

            $query .= " ORDER BY Nombre ASC LIMIT $offset, $limite";

            $sql = main::conectar()->prepare($query);
            $sql->execute();
            
            return $sql->fetchAll(); // Devuelve el array con los departamentos
        }

        /*--- Función para agregar (la que ya usas en el controlador) ---*/
        protected static function agregar_dispositivo_modelo($datos){
            $sql = main::conectar()->prepare("INSERT INTO catcdispositivos(Nombre, Vigente) VALUES(:Nombre, :Vigente)");
            $sql->bindParam(":Nombre", $datos['nombre']);
            $sql->bindParam(":Vigente", $datos['vigente']);
            $sql->execute();
            return $sql;
        }

        /*--- Función para eliminar ---*/
        protected static function eliminar_dispositivo_modelo($id){
            $sql = main::conectar()->prepare("DELETE FROM catcdispositivos WHERE IdDispositivo = :ID");
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        }

        /*--- Función para actualizar ---*/
        protected static function actualizar_dispositivo_modelo($datos){
            $sql = main::conectar()->prepare("UPDATE catcdispositivos SET Nombre = :Nombre, Vigente = :Vigente WHERE IdDispositivo = :ID");
            $sql->bindParam(":Nombre", $datos['nombre']);
            $sql->bindParam(":Vigente", $datos['vigente']);
            $sql->bindParam(":ID", $datos['id']);
            $sql->execute();
            return $sql;
        }
    }