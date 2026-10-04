<?php
if(isset($peticionAjax) && $peticionAjax){
    require_once "../config/main.php";
}else{
    require_once "./config/main.php";
}

class depModelo extends main{

    protected static function contar_departamentos_modelo($busqueda){
        if($busqueda != ""){
            $sql = main::conectar()->prepare(
                "SELECT COUNT(IdDepartamento) FROM catcdepartamentos WHERE Nombre LIKE :busqueda"
            );
            $sql->bindValue(':busqueda', '%' . $busqueda . '%');
        } else {
            $sql = main::conectar()->prepare(
                "SELECT COUNT(IdDepartamento) FROM catcdepartamentos"
            );
        }
        $sql->execute();
        return $sql->fetchColumn();
    }

    protected static function listar_departamentos_modelo($limite, $offset, $busqueda){
        if($busqueda != ""){
            $sql = main::conectar()->prepare(
                "SELECT * FROM catcdepartamentos WHERE Nombre LIKE :busqueda ORDER BY Nombre ASC LIMIT :offset, :limite"
            );
            $sql->bindValue(':busqueda', '%' . $busqueda . '%');
        } else {
            $sql = main::conectar()->prepare(
                "SELECT * FROM catcdepartamentos ORDER BY Nombre ASC LIMIT :offset, :limite"
            );
        }
        $sql->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $sql->bindValue(':limite', (int)$limite,  PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll();
    }

    protected static function agregar_departamento_modelo($datos){
        $sql = main::conectar()->prepare(
            "INSERT INTO catcdepartamentos(Nombre, Vigente) VALUES(:Nombre, :Vigente)"
        );
        $sql->bindParam(":Nombre",  $datos['nombre']);
        $sql->bindParam(":Vigente", $datos['vigente']);
        $sql->execute();
        return $sql;
    }

    protected static function eliminar_departamento_modelo($id){
        $sql = main::conectar()->prepare(
            "DELETE FROM catcdepartamentos WHERE IdDepartamento = :ID"
        );
        $sql->bindParam(":ID", $id, PDO::PARAM_INT);
        $sql->execute();
        return $sql;
    }

    protected static function actualizar_departamento_modelo($datos){
        $sql = main::conectar()->prepare(
            "UPDATE catcdepartamentos SET Nombre = :Nombre, Vigente = :Vigente WHERE IdDepartamento = :ID"
        );
        $sql->bindParam(":Nombre",  $datos['nombre']);
        $sql->bindParam(":Vigente", $datos['vigente']);
        $sql->bindParam(":ID",      $datos['id'], PDO::PARAM_INT);
        $sql->execute();
        return $sql;
    }
}