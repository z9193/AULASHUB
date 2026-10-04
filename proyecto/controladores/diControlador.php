<?php
if(isset($peticionAjax) && $peticionAjax){
    require_once "../modelos/diModelo.php";
}else{
    require_once "./modelos/diModelo.php";
}

class diControlador extends diModelo {

    const FILAS_POR_PAGINA = 10;

    // ──────────────────────────────────────────
    //  BUSCAR
    // ──────────────────────────────────────────
    public function buscar_dispositivo_controlador(){
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
    public function paginador_dispositivo_controlador($pagina, $modo = 'buscar'){

        if(session_status() === PHP_SESSION_NONE){
            session_start(['name' => 'SPM']);
        }

        $busqueda = ($modo === 'buscar' && isset($_SESSION['busqueda_enlace']))
                    ? $_SESSION['busqueda_enlace'] : '';

        $pagina = max(1, (int)$pagina);
        $limite = self::FILAS_POR_PAGINA;
        $offset = ($pagina - 1) * $limite;

        $totalRegistros = diModelo::contar_dispositivo_modelo($busqueda);
        $totalPaginas   = ($totalRegistros > 0) ? (int)ceil($totalRegistros / $limite) : 1;
        $registros      = diModelo::listar_dispositivo_modelo($limite, $offset, $busqueda);

        $urlBase = ($modo === 'buscar')
                ? SERVERURL . '?views=dispositivo-buscar/'
                : SERVERURL . '?views=dispositivo-lista/';

        $filas = '';

        if(empty($registros)){
            $filas = '<tr><td colspan="6" class="text-center text-muted small py-3">
                        <i class="fas fa-search-minus fa-fw"></i> &nbsp; No se encontraron resultados.
                    </td></tr>';
        } else {
            $contador = $offset + 1;
            foreach($registros as $en){
                $idEnc        = main::encryption($en['IdDispositivo']);
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
                    <td>' . htmlspecialchars($en['IdDispositivo'], ENT_QUOTES) . '</td>
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
    public function agregar_dispositivo_controlador(){
        $nombre  = main::limpiar_cadena($_POST['di_nombre_reg']);
        $vigente = 1;

        if($nombre == ""){
            echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Campo vacío!','Texto'=>'El nombre del dispositivo no puede estar vacío.','Tipo'=>'error']);
            exit();
        }

        $datos = ["nombre" => $nombre, "vigente" => $vigente];
        $res   = diModelo::agregar_dispositivo_modelo($datos);

        echo json_encode($res->rowCount() >= 1
            ? ['Alerta'=>'recargar','Titulo'=>'¡Registrado!', 'Texto'=>'Dispositivo registrado exitosamente.','Tipo'=>'success']
            : ['Alerta'=>'simple',  'Titulo'=>'¡Error!',      'Texto'=>'No se pudo registrar el dispositivo.','Tipo'=>'error']
        );
        exit();
    }

    // ──────────────────────────────────────────
    //  ELIMINAR
    // ──────────────────────────────────────────
    public function eliminar_dispositivo_controlador(){
        $idEnc = isset($_POST['di_id_del']) ? $_POST['di_id_del'] : '';
        $id    = main::decryption($idEnc);

        if(empty($id) || !is_numeric($id)){
            echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Error!','Texto'=>'ID de dispositivo inválido.','Tipo'=>'error']);
            exit();
        }

        $res = diModelo::eliminar_dispositivo_modelo((int)$id);

        echo json_encode($res->rowCount() >= 1
            ? ['Alerta'=>'recargar','Titulo'=>'¡Eliminado!', 'Texto'=>'Dispositivo eliminado correctamente.','Tipo'=>'success']
            : ['Alerta'=>'simple',  'Titulo'=>'¡Error!',     'Texto'=>'No se pudo eliminar el dispositivo.', 'Tipo'=>'error']
        );
        exit();
    }

    // ──────────────────────────────────────────
    //  ACTUALIZAR
    // ──────────────────────────────────────────
    public function actualizar_dispositivo_controlador(){
        $idEnc   = main::limpiar_cadena($_POST['di_id_upd']);
        $id      = main::decryption($idEnc);
        $nombre  = main::limpiar_cadena($_POST['di_nombre_upd']);
        $vigente = main::limpiar_cadena($_POST['di_vigente_upd']);

        if(empty($id) || !is_numeric($id) || $nombre == "" || $vigente === ""){
            echo json_encode(['Alerta'=>'simple','Titulo'=>'¡Campos incompletos!','Texto'=>'Completa todos los campos para actualizar el dispositivo.','Tipo'=>'error']);
            exit();
        }

        $datos = ["id" => (int)$id, "nombre" => $nombre, "vigente" => $vigente];
        $res   = diModelo::actualizar_dispositivo_modelo($datos);

        echo json_encode($res->rowCount() >= 1
            ? ['Alerta'=>'recargar','Titulo'=>'¡Actualizado!', 'Texto'=>'Dispositivo actualizado correctamente.','Tipo'=>'success']
            : ['Alerta'=>'simple',  'Titulo'=>'¡Sin cambios!', 'Texto'=>'No se detectaron cambios en el dispositivo.', 'Tipo'=>'error']
        );
        exit();
    }
}