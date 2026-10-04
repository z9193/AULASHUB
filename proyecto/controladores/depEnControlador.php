<?php
if(isset($peticionAjax) && $peticionAjax){
    require_once "../modelos/depEnModelo.php";
}else{
    require_once "./modelos/depEnModelo.php";
}

class depEnlControlador extends depEnlModelo{

    // Carga inicial: devuelve ambos selects en JSON
    public function cargar_selects_controlador(){
        $departamentos = depEnlModelo::listar_departamentos_select_modelo();
        $enlaces       = depEnlModelo::listar_enlaces_select_modelo();

        return json_encode([
            'departamentos' => $departamentos,
            'enlaces'       => $enlaces
        ]);
    }

    // Vincular
    public function vincular_controlador(){
        $idDepEnc = main::limpiar_cadena($_POST['dep_id']);
        $idEnlEnc = main::limpiar_cadena($_POST['enlace_id']);

        $idDep = main::decryption($idDepEnc);
        $idEnl = main::decryption($idEnlEnc);

        if(empty($idDep) || !is_numeric($idDep) || empty($idEnl) || !is_numeric($idEnl)){
            return json_encode(['Alerta'=>'simple','Titulo'=>'¡Campos incompletos!','Texto'=>'Selecciona un departamento y un enlace.','Tipo'=>'error']);
        }

        // Verificar duplicado
        $existe = depEnlModelo::verificar_vinculo_modelo((int)$idDep, (int)$idEnl);
        if($existe > 0){
            return json_encode(['Alerta'=>'simple','Titulo'=>'¡Ya existe!','Texto'=>'Este departamento ya está vinculado con ese enlace.','Tipo'=>'warning']);
        }

        $res = depEnlModelo::vincular_modelo((int)$idDep, (int)$idEnl,$vigente = 1); // Vigente = 1 para nuevo vínculo

        return json_encode($res->rowCount() >= 1
            ? ['Alerta'=>'recargar','Titulo'=>'¡Vinculado!', 'Texto'=>'Vínculo registrado correctamente.','Tipo'=>'success']
            : ['Alerta'=>'simple',  'Titulo'=>'¡Error!',     'Texto'=>'No se pudo registrar el vínculo.', 'Tipo'=>'error']
        );
    }

    // Eliminar vínculo
    public function eliminar_vinculo_controlador(){
    // Desencriptamos ambos IDs que vienen de la tabla
    $idDepEnc = main::limpiar_cadena($_POST['dep_id']);
    $idEnlEnc = main::limpiar_cadena($_POST['enlace_id']);

    $idDep = main::decryption($idDepEnc);
    $idEnl = main::decryption($idEnlEnc);

    // Validación básica
    if(empty($idDep) || empty($idEnl)){
        return json_encode(['Alerta'=>'simple','Titulo'=>'¡Error!','Texto'=>'No se pudo identificar el vínculo.','Tipo'=>'error']);
    }

    // Aquí estaba el error de paréntesis que tenías:
$res = depEnlModelo::eliminar_vinculo_modelo((int) $idDep); // Solo necesitamos el ID del departamento para eliminar el vínculo, asumiendo que es único por departamento

    if($res->rowCount() >= 1){
        return json_encode([
            'Alerta'=>'recargar',
            'Titulo'=>'¡Eliminado!', 
            'Texto'=>'El vínculo ha sido removido.',
            'Tipo'=>'success'
        ]);
    } else {
        return json_encode([
            'Alerta'=>'simple',  
            'Titulo'=>'¡Error!',     
            'Texto'=>'No se pudo eliminar el vínculo.', 
            'Tipo'=>'error'
        ]);
    }
}
    // Listar vínculos existentes para la tabla
    public function listar_vinculos_controlador(){
        // Llamamos al modelo que creamos anteriormente (asegúrate de tener listar_vinculos_modelo en depEnModelo.php)
        $datos = self::listar_vinculos_modelo();
        $tabla = "";
        $contador = 1;

        foreach($datos as $row){
            // Usamos los alias 'nombre_dep' y 'nombre_enl' que definimos en el SELECT con INNER JOIN
            $tabla .= '
            <tr class="text-center">
                <td>'.$contador.'</td>
                <td>'.$row['nombre_dep'].'</td>
                <td>'.$row['nombre_enl'].'</td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="eliminarVinculo(\''.$row['IdDepartamento'].'\', \''.$row['IdEnlace'].'\')">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            </tr>';
            $contador++;
        }

        if($contador == 1){
            $tabla .= '<tr><td colspan="4" class="text-center">No hay vínculos registrados actualmente</td></tr>';
        }

        return $tabla;
    }
}