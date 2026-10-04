<?php
	
	require_once "../config/main.php";

	class modeloUsuario extends main{

public static function iniciar_sesion_modelo($datos){ // Asegúrate de que diga static
    $conexion = main::conectar(); // Primero guardamos la conexión en una variable
    $sql = $conexion->prepare(
        "SELECT * FROM catcusuarios 
        WHERE NumeroEmpleado = :numero 
        LIMIT 1"
    );

    $sql->bindParam(":numero", $datos['numero_empleado']);
    $sql->execute();

    return $sql;
}

		/*--------- Modelo agregar usuario ---------*/
		protected static function agregar_usuario_modelo($datos){
			$sql = main::conectar()->prepare("
		INSERT INTO catcusuarios 
		(Nombre,PrimerApellido,SegundoApellido,NumeroEmpleado,Contraseña) 
		VALUES 
		(:Nombre,:PrimerApellido,:SegundoApellido,:NumeroEmpleado,:Contraseña)");
		$sql->bindParam(":Nombre",$datos['Nombre']);
		$sql->bindParam(":PrimerApellido",$datos['PrimerApellido']);
		$sql->bindParam(":SegundoApellido",$datos['SegundoApellido']);
		$sql->bindParam(":NumeroEmpleado",$datos['NumeroEmpleado']);
		$sql->bindParam(":Contraseña",$datos['Contraseña']);
		$sql->execute();

	return $sql;
}

		/*--------- Modelo eliminar usuario ---------*/
		protected static function eliminar_usuario_modelo($id){
			$sql=main::conectar()->prepare("DELETE FROM catcusuarios WHERE IdUsuario=:ID");

			$sql->bindParam(":ID",$id);
			$sql->execute();

			return $sql;			
		}

		/*--------- Modelo datos usuario ---------*/
		protected static function datos_usuaurio_modelo($tipo, $id){
			if($tipo=="Unico"){
				$sql=main::conectar()->prepare("SELECT * FROM catcusuarios WHERE IdUsuario=:ID");
				$sql->bindParam(":ID",$id);

			}elseIF($tipo=="Conteo"){
				$sql=main::conectar()->prepare("SELECT IdUsuario FROM catcusuarios WHERE IdUsuario!='1'");
			}
			$sql->execute();
			return $sql;
		}

		/*--------- Modelo para actualizar usuario ---------*/
		protected static function actualizar_usuario_modelo($datos){
			$sql=main::conectar()->prepare("UPDATE catcusuarios SET Nombre=:Nombre,PrimerApellido=:PrimerApellido,SegundoApellido=:SegundoApellido,
			NumeroEmpleado=:NumeroEmpleado,Contraseña=:Contraseña WHERE IdUsuario=:ID");
			
			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":PrimerApellido",$datos['PrimerApellido']);
			$sql->bindParam(":SegundoApellido",$datos['SegundoApellido']);		
			$sql->bindParam(":NumeroEmpleado",$datos['NumeroEmpleado']);
			$sql->bindParam(":Contraseña",$datos['Contraseña']);		
			$sql->bindParam(":ID",$datos['ID']);
			$sql->execute();
			
			return $sql;
		}

    }