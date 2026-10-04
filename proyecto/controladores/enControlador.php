<?php
if(isset($peticionAjax) && $peticionAjax){
    require_once "../modelos/enModelo.php";
}else{
    require_once "./modelos/enModelo.php";
}

class enControlador extends enModelo {

    const FILAS_POR_PAGINA = 10;

    // ──────────────────────────────────────────
    //  BUSCAR
    // ──────────────────────────────────────────
    public function buscar_enlace_controlador(){
        $busqueda = main::limpiar_cadena($_POST['busqueda_inicial']);

        if($busqueda == ""){
            echo json_encode(['Alerta'=>'simple','Titulo'=>'Campo vacío','Texto'=>'Introduce un término de búsqueda.','Tipo'=>'error']);
            exit();
        }

        if(session_status() === PHP_SESSION_NONE){
            session_start(['name' => 'SPM']);
        }
        $_SESSION['busqueda_enlace'] = $busqueda;

        echo json_encode([
            'Alerta' => 'redireccionar',
            'URL'    => SERVERURL . '?views=enlace-buscar'
        ]);
        exit();
    }

    // ──────────────────────────────────────────
    //  PAGINADOR
    // ──────────────────────────────────────────
    public function paginador_enlace_controlador($pagina, $modo = 'buscar'){

        if(session_status() === PHP_SESSION_NONE){
            session_start(['name' => 'SPM']);
        }

        $busqueda = ($modo === 'buscar' && isset($_SESSION['busqueda_enlace']))
                    ? $_SESSION['busqueda_enlace'] : '';

        $pagina = max(1, (int)$pagina);
        $limite = self::FILAS_POR_PAGINA;
        $offset = ($pagina - 1) * $limite;

        $totalRegistros = enModelo::contar_enlace_modelo($busqueda);
        $totalPaginas   = ($totalRegistros > 0) ? (int)ceil($totalRegistros / $limite) : 1;
        $registros      = enModelo::listar_enlace_modelo($limite, $offset, $busqueda);

        $urlBase = ($modo === 'buscar')
                ? SERVERURL . '?views=enlace-buscar/'
                : SERVERURL . '?views=enlace-lista/';

        $filas = '';

        if(empty($registros)){
            $filas = '<tr><td colspan="6" class="text-center text-muted small py-3">
                        <i class="fas fa-search-minus fa-fw"></i> &nbsp; No se encontraron resultados.
                    </td></tr>';
        } else {
            $contador = $offset + 1;
            foreach($registros as $en){
                $idEnc        = main::encryption($en['IdEnlace']);
                $badgeVigente = ($en['Vigente'] == 1)
                    ? '<span class="badge bg-success">Vigente</span>'
                    : '<span class="badge bg-secondary">Inactivo</span>';

                if($modo === 'lista'){
                    $accionesHtml = '
                    <td class="text-center">
                        <button type="button" class="btn btn-success btn-xs btn-actualizar-en"
                            data-id="'     . htmlspecialchars($idEnc,          ENT_QUOTES) . '"
                            data-nombre="' . htmlspecialchars($en['Nombre'],  ENT_QUOTES) . '"
                            data-vigente="'. htmlspecialchars($en['Vigente'], ENT_QUOTES) . '"
                            title="Actualizar"><i class="fas fa-sync-alt"></i></button>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-xs btn-eliminar-en"
                            data-id="'     . htmlspecialchars($idEnc,          ENT_QUOTES) . '"
                            data-nombre="' . htmlspecialchars($en['Nombre'], ENT_QUOTES) . '"
                            title="Eliminar"><i class="far fa-trash-alt"></i></button>
                    </td>';
                } else {
                    $accionesHtml = '
                    <td class="text-center">
                        <button type="button" class="btn btn-primary btn-xs btn-info-en"
                            data-id="' . htmlspecialchars($idEnc, ENT_QUOTES) . '"
                            title="Ver detalle"><i class="fas fa-info-circle"></i></button>
                    </td>';
                }

                $filas .= '
                <tr class="text-center small">
                    <td>' . $contador . '</td>
                    <td>' . htmlspecialchars($en['IdEnlace'], ENT_QUOTES) . '</td>
                    <td>' . htmlspecialchars($en['Nombre'],         ENT_QUOTES) . '</td>
                    <td>' . $badgeVigente . '</td>
                    ' . $accionesHtml . '
                </tr>';
                $contador++;
            }
        }

        $paginadorHtml = main::paginador_tablas($pagina, $totalPaginas, $urlBase, 5);
        
        // Retornamos las filas y el paginador separados por |||
        return $filas . '|||' . $paginadorHtml;
    }

    // ──────────────────────────────────────────
    //  AGREGAR
    // ──────────────────────────────────────────
    public function agregar_enlace_controlador(){
        $nombre  = main::limpiar_cadena($_POST['en_nombre_reg']);
        $vigente = 1;

        if($nombre == ""){
            echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Campo vacío!','Texto'=>'El nombre del enlace no puede estar vacío.','Tipo'=>'error']);
            exit();
        }

        $datos = ["nombre" => $nombre, "vigente" => $vigente];
        $res   = enModelo::agregar_enlace_modelo($datos);

        echo json_encode($res->rowCount() >= 1
            ? ['Alerta'=>'recargar','Titulo'=>'¡Registrado!', 'Texto'=>'Enlace registrado exitosamente.','Tipo'=>'success']
            : ['Alerta'=>'simple',  'Titulo'=>'¡Error!',      'Texto'=>'No se pudo registrar el enlace.','Tipo'=>'error']
        );
        exit();
    }

    // ──────────────────────────────────────────
    //  ELIMINAR
    // ──────────────────────────────────────────
    public function eliminar_enlace_controlador(){
        $idEnc = isset($_POST['en_id_del']) ? $_POST['en_id_del'] : '';
        $id    = main::decryption($idEnc);

        if(empty($id) || !is_numeric($id)){
            echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Error!','Texto'=>'ID de enlace inválido.','Tipo'=>'error']);
            exit();
        }

        $res = enModelo::eliminar_enlace_modelo((int)$id);

        echo json_encode($res->rowCount() >= 1
            ? ['Alerta'=>'recargar','Titulo'=>'¡Eliminado!', 'Texto'=>'Enlace eliminado correctamente.','Tipo'=>'success']
            : ['Alerta'=>'simple',  'Titulo'=>'¡Error!',     'Texto'=>'No se pudo eliminar el enlace.', 'Tipo'=>'error']
        );
        exit();
    }

    // ──────────────────────────────────────────
    //  ACTUALIZAR
    // ──────────────────────────────────────────
    public function actualizar_enlace_controlador(){
        $idEnc   = main::limpiar_cadena($_POST['en_id_upd']);
        $id      = main::decryption($idEnc);
        $nombre  = main::limpiar_cadena($_POST['en_nombre_upd']);
        $vigente = main::limpiar_cadena($_POST['en_vigente_upd']);

        if(empty($id) || !is_numeric($id) || $nombre == "" || $vigente === ""){
            echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Campos incompletos!','Texto'=>'Completa todos los campos para actualizar el enlace.','Tipo'=>'error']);
            exit();
        }

        $datos = ["id" => (int)$id, "nombre" => $nombre, "vigente" => $vigente];
        $res   = enModelo::actualizar_enlace_modelo($datos);

        echo json_encode($res->rowCount() >= 1
            ? ['Alerta'=>'recargar','Titulo'=>'¡Actualizado!', 'Texto'=>'Enlace actualizado correctamente.','Tipo'=>'success']
            : ['Alerta'=>'simple',  'Titulo'=>'¡Sin cambios!', 'Texto'=>'No se detectaron cambios en el enlace.', 'Tipo'=>'error']
        );
        exit();
    }
}