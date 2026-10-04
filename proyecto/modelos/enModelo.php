<?php
if(isset($peticionAjax) && $peticionAjax){
    require_once "../config/main.php";
}else{
    require_once "./config/main.php";
}

class enModelo extends main{

 /*--- Función para contar registros (para el paginador) ---*/
        protected static function contar_enlace_modelo($busqueda){
            $query = "SELECT COUNT(IdEnlace) FROM catcenlaces";
            
            // Si hay una búsqueda, filtramos
            if($busqueda != ""){
                $query .= " WHERE Nombre LIKE '%$busqueda%'";
            }

            $sql = main::conectar()->prepare($query);
            $sql->execute();
            return $sql->fetchColumn();
        }

        /*--- Función para listar los registros con límite y offset ---*/
        protected static function listar_enlace_modelo($limite, $offset, $busqueda){
            $query = "SELECT * FROM catcenlaces";

            if($busqueda != ""){
                $query .= " WHERE Nombre LIKE '%$busqueda%'";
            }

            $query .= " ORDER BY Nombre ASC LIMIT $offset, $limite";

            $sql = main::conectar()->prepare($query);
            $sql->execute();
            
            return $sql->fetchAll(); // Devuelve el array con los departamentos
        }

        /*--- Función para agregar (la que ya usas en el controlador) ---*/
        protected static function agregar_enlace_modelo($datos){
            $sql = main::conectar()->prepare("INSERT INTO catcenlaces(Nombre, Vigente) VALUES(:Nombre, :Vigente)");
            $sql->bindParam(":Nombre", $datos['nombre']);
            $sql->bindParam(":Vigente", $datos['vigente']);
            $sql->execute();
            return $sql;
        }

        /*--- Función para eliminar ---*/
        protected static function eliminar_enlace_modelo($id){
            $sql = main::conectar()->prepare("DELETE FROM catcenlaces WHERE IdEnlace = :ID");
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        }

        /*--- Función para actualizar ---*/
        protected static function actualizar_enlace_modelo($datos){
            $sql = main::conectar()->prepare("UPDATE catcdenlaces SET Nombre = :Nombre, Vigente = :Vigente WHERE IdEnlace = :ID");
            $sql->bindParam(":Nombre", $datos['nombre']);
            $sql->bindParam(":Vigente", $datos['vigente']);
            $sql->bindParam(":ID", $datos['id']);
            $sql->execute();
            return $sql;
        }
    }