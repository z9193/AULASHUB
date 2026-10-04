<?php
if(isset($peticionAjax) && $peticionAjax){
    require_once "../modelos/depModelo.php";
}else{
    require_once "./modelos/depModelo.php";
}

class depControlador extends depModelo{

    const FILAS_POR_PAGINA = 10;

    // ──────────────────────────────────────────
    //  BUSCAR
    // ──────────────────────────────────────────
    public function buscar_departamento_controlador(){
        $busqueda = main::limpiar_cadena($_POST['busqueda_inicial']);

        if($busqueda == ""){
            return json_encode(['Alerta'=>'simple','Titulo'=>'Campo vacío','Texto'=>'Introduce un término de búsqueda.','Tipo'=>'error']);
        }

        if(session_status() === PHP_SESSION_NONE){
            session_start(['name' => 'SPM']);
        }
        $_SESSION['busqueda_departamento'] = $busqueda;

        return json_encode([
            'Alerta' => 'redireccionar',
            'URL'    => SERVERURL . '?views=departamentos-buscar'
        ]);
    }

    // ──────────────────────────────────────────
    //  PAGINADOR  (no cambia — no hace echo/exit)
    // ──────────────────────────────────────────
    public function paginador_departamento_controlador($pagina, $modo = 'buscar'){

        if(session_status() === PHP_SESSION_NONE){
            session_start(['name' => 'SPM']);
        }

        $busqueda = ($modo === 'buscar' && isset($_SESSION['busqueda_departamento']))
                    ? $_SESSION['busqueda_departamento'] : '';

        $pagina = max(1, (int)$pagina);
        $limite = self::FILAS_POR_PAGINA;
        $offset = ($pagina - 1) * $limite;

        $totalRegistros = depModelo::contar_departamentos_modelo($busqueda);
        $totalPaginas   = ($totalRegistros > 0) ? (int)ceil($totalRegistros / $limite) : 1;
        $registros      = depModelo::listar_departamentos_modelo($limite, $offset, $busqueda);

        $urlBase = ($modo === 'buscar')
                ? SERVERURL . '?views=departamentos-buscar/'
                : SERVERURL . '?views=departamentos-lista/';

        $filas = '';

        if(empty($registros)){
            $filas = '<tr><td colspan="6" class="text-center text-muted small py-3">
                        <i class="fas fa-search-minus fa-fw"></i> &nbsp; No se encontraron resultados.
                    </td></tr>';
        } else {
            $contador = $offset + 1;
            foreach($registros as $dep){
                $idEnc        = main::encryption($dep['IdDepartamento']);
                $badgeVigente = ($dep['Vigente'] == 1)
                    ? '<span class="badge bg-success">Vigente</span>'
                    : '<span class="badge bg-secondary">Inactivo</span>';

                if($modo === 'lista'){
                    $accionesHtml = '
                    <td class="text-center">
                        <button type="button" class="btn btn-success btn-xs btn-actualizar-dep"
                            data-id="'     . htmlspecialchars($idEnc,          ENT_QUOTES) . '"
                            data-nombre="' . htmlspecialchars($dep['Nombre'],  ENT_QUOTES) . '"
                            data-vigente="'. htmlspecialchars($dep['Vigente'], ENT_QUOTES) . '"
                            title="Actualizar"><i class="fas fa-sync-alt"></i></button>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-xs btn-eliminar-dep"
                            data-id="'     . htmlspecialchars($idEnc,         ENT_QUOTES) . '"
                            data-nombre="' . htmlspecialchars($dep['Nombre'], ENT_QUOTES) . '"
                            title="Eliminar"><i class="far fa-trash-alt"></i></button>
                    </td>';
                } else {
                    $accionesHtml = '
                    <td class="text-center">
                        <button type="button" class="btn btn-primary btn-xs btn-info-dep"
                            data-id="' . htmlspecialchars($idEnc, ENT_QUOTES) . '"
                            title="Ver detalle"><i class="fas fa-info-circle"></i></button>
                    </td>';
                }

                $filas .= '
                <tr class="text-center small">
                    <td>' . $contador . '</td>
                    <td>' . htmlspecialchars($dep['IdDepartamento'], ENT_QUOTES) . '</td>
                    <td>' . htmlspecialchars($dep['Nombre'],         ENT_QUOTES) . '</td>
                    <td>' . $badgeVigente . '</td>
                    ' . $accionesHtml . '
                </tr>';
                $contador++;
            }
        }

        $paginadorHtml = main::paginador_tablas($pagina, $totalPaginas, $urlBase, 5);
        return $filas . '|||' . $paginadorHtml;
    }

    // ──────────────────────────────────────────
    //  AGREGAR
    // ──────────────────────────────────────────
    public function agregar_departamento_controlador(){
        $nombre  = main::limpiar_cadena($_POST['dep_nombre_reg']);
        $vigente = 1;

        if($nombre == ""){
            return json_encode(['Alerta'=>'simple','Titulo'=>'¡Campo vacío!','Texto'=>'El nombre del departamento no puede estar vacío.','Tipo'=>'error']);
        }

        $datos = ["nombre" => $nombre, "vigente" => $vigente];
        $res   = depModelo::agregar_departamento_modelo($datos);

        return json_encode($res->rowCount() >= 1
            ? ['Alerta'=>'recargar','Titulo'=>'¡Registrado!', 'Texto'=>'Departamento registrado exitosamente.','Tipo'=>'success']
            : ['Alerta'=>'simple',  'Titulo'=>'¡Error!',      'Texto'=>'No se pudo registrar el departamento.','Tipo'=>'error']
        );
    }

    // ──────────────────────────────────────────
    //  ELIMINAR
    // ──────────────────────────────────────────
    public function eliminar_departamento_controlador(){
        $idEnc = isset($_POST['dep_id_del']) ? $_POST['dep_id_del'] : '';
        $id    = main::decryption($idEnc);

        if(empty($id) || !is_numeric($id)){
            return json_encode(['Alerta'=>'simple','Titulo'=>'¡Error!','Texto'=>'ID inválido.','Tipo'=>'error']);
        }

        $res = depModelo::eliminar_departamento_modelo((int)$id);

        return json_encode($res->rowCount() >= 1
            ? ['Alerta'=>'recargar','Titulo'=>'¡Eliminado!', 'Texto'=>'Departamento eliminado correctamente.','Tipo'=>'success']
            : ['Alerta'=>'simple',  'Titulo'=>'¡Error!',     'Texto'=>'No se pudo eliminar el departamento.', 'Tipo'=>'error']
        );
    }

    // ──────────────────────────────────────────
    //  ACTUALIZAR
    // ──────────────────────────────────────────
    public function actualizar_departamento_controlador(){
        $idEnc   = main::limpiar_cadena($_POST['dep_id_upd']);
        $id      = main::decryption($idEnc);
        $nombre  = main::limpiar_cadena($_POST['dep_nombre_upd']);
        $vigente = main::limpiar_cadena($_POST['dep_vigente_upd']);

        if(empty($id) || !is_numeric($id) || $nombre == "" || $vigente === ""){
            return json_encode(['Alerta'=>'simple','Titulo'=>'¡Campos incompletos!','Texto'=>'Completa todos los campos.','Tipo'=>'error']);
        }

        $datos = ["id" => (int)$id, "nombre" => $nombre, "vigente" => $vigente];
        $res   = depModelo::actualizar_departamento_modelo($datos);

        return json_encode($res->rowCount() >= 1
            ? ['Alerta'=>'recargar','Titulo'=>'¡Actualizado!', 'Texto'=>'Departamento actualizado correctamente.','Tipo'=>'success']
            : ['Alerta'=>'simple',  'Titulo'=>'¡Sin cambios!', 'Texto'=>'No se detectaron cambios.',             'Tipo'=>'error']
        );
    }
}