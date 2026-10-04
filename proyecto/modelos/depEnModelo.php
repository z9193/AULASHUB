<?php
if(isset($peticionAjax) && $peticionAjax){
    require_once "../config/main.php";
}else{
    require_once "./config/main.php";
}

class depEnlModelo extends main {

    protected static function listar_departamentos_select_modelo(){
        $sql = main::conectar()->prepare(
            "SELECT IdDepartamento, Nombre FROM catcdepartamentos WHERE Vigente = 1 ORDER BY Nombre ASC"
        );
        $sql->execute();
        $rows = $sql->fetchAll();
        
        $instancia = new main(); // Creamos la instancia aquí
        foreach($rows as &$row){
            $row['IdDepartamento_enc'] = $instancia->encryption($row['IdDepartamento']);
        }
        return $rows;
    }

    protected static function listar_enlaces_select_modelo(){
        $sql = main::conectar()->prepare(
            "SELECT IdEnlace, Nombre FROM catcenlaces WHERE Vigente = 1 ORDER BY Nombre ASC"
        );
        $sql->execute();
        $rows = $sql->fetchAll();
        
        $instancia = new main(); // Creamos la instancia aquí
        foreach($rows as &$row){
            $row['IdEnlace_enc'] = $instancia->encryption($row['IdEnlace']);
        }
        return $rows;
    }

    
        protected static function eliminar_vinculo_modelo($id){
            $sql = main::conectar()->prepare("DELETE FROM catcdepartamentosenlaces WHERE IdDepartamento = :ID");
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        }

    // Los métodos de verificación e inserción están bien porque no usan encryption
    protected static function verificar_vinculo_modelo($idDep, $idEnl){
        $sql = main::conectar()->prepare(
            "SELECT COUNT(*) FROM catcdepartamentosenlaces WHERE IdDepartamento = :IdDep AND IdEnlace = :IdEnl"
        );
        $sql->bindParam(':IdDep', $idDep);
        $sql->bindParam(':IdEnl', $idEnl);
        $sql->execute();
        return (int)$sql->fetchColumn();
    }

    protected static function vincular_modelo($idDep, $idEnl, $vigente){
        $sql = main::conectar()->prepare(
            "INSERT INTO catcdepartamentosenlaces (IdDepartamento, IdEnlace, Vigente) VALUES (:IdDep, :IdEnl, :Vigente)"
        );
        $sql->bindParam(':IdDep', $idDep);
        $sql->bindParam(':IdEnl', $idEnl);
        $sql->bindParam(":Vigente", $vigente);
        $sql->execute();
        return $sql;
    }

    /*--- Función para listar los vínculos ya existentes ---*/
    protected static function listar_vinculos_modelo(){
        // Usamos INNER JOIN para traer los nombres desde las tablas de catálogo
        $sql = main::conectar()->prepare(
            "SELECT T1.IdDepartamento, T1.IdEnlace, 
                    D.Nombre as nombre_dep, 
                    E.Nombre as nombre_enl 
            FROM catcdepartamentosenlaces T1
            INNER JOIN catcdepartamentos D ON T1.IdDepartamento = D.IdDepartamento
            INNER JOIN catcenlaces E ON T1.IdEnlace = E.IdEnlace"
        );
        $sql->execute();
        return $sql->fetchAll();
    }
}