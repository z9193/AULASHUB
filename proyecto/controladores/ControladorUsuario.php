<?php

    if(isset($peticionAjax) && $peticionAjax){
        require_once "../modelos/modeloUsuario.php";
    }else{
        require_once "./modelos/modeloUsuario.php";
    }

    class ControladorUsuario extends modeloUsuario{

        // ──────────────────────────────────────────
        //  LOGIN
        // ──────────────────────────────────────────
public function iniciar_sesion_controlador(){

    $numeroempleado = strtoupper(main::limpiar_cadena($_POST['numero_empleado']));
    $clave_input = main::limpiar_cadena($_POST['clave']);

    if($numeroempleado == "" || $clave_input == ""){
        echo json_encode([
            'Alerta' => 'simple',
            'Titulo' => 'Campos vacíos',
            'Texto'  => 'Por favor completa todos los campos.',
            'Tipo'   => 'error'
        ]);
        exit();
    }

    // 🔧 USAR MODELO
    $datosLogin = [
        "numero_empleado" => $numeroempleado
    ];

    $consulta = modeloUsuario::iniciar_sesion_modelo($datosLogin);

    if($consulta->rowCount() == 1){
        $datos = $consulta->fetch(PDO::FETCH_ASSOC);

        $clave_encriptada = main::encryption($clave_input);

        // 🔧 validar contraseña
        $clave_encriptada = main::encryption($clave_input);

        if($datos['Contraseña'] === $clave_input){

            if(session_status() === PHP_SESSION_NONE){
                session_start(['name' => 'SPM']);
            }

            $_SESSION['usuario']         = $datos['NumeroEmpleado'];
            $_SESSION['nombre']          = $datos['Nombre'];
            $_SESSION['primerapellido']  = $datos['PrimerApellido'];

            echo json_encode([
                'Alerta' => 'redirigir',
                'URL'    => SERVERURL . '?views=home'
            ]);

        } else {
            echo json_encode([
                'Alerta' => 'simple',
                'Titulo' => 'Credenciales incorrectas',
                'Texto'  => 'La contraseña es incorrecta.',
                'Tipo'   => 'error'
            ]);
        }

    } else {
        echo json_encode([
            'Alerta' => 'simple',
            'Titulo' => 'Credenciales incorrectas',
            'Texto'  => 'El usuario no existe.',
            'Tipo'   => 'error'
        ]);
    }

    exit();
}
        // ──────────────────────────────────────────
        //  AGREGAR USUARIO
        // ──────────────────────────────────────────
        public function agregar_usuario_controlador(){ 
            
            $nombre          = strtoupper(main::limpiar_cadena($_POST['usuario_nombre_reg']));
            $primerapellido  = strtoupper(main::limpiar_cadena($_POST['usuario_primer_apellido_reg']));
            $segundoapellido = strtoupper(main::limpiar_cadena($_POST['usuario_segundo_apellido_reg']));
            $numeroempleado  = strtoupper(main::limpiar_cadena($_POST['usuario_numero_empleado_reg']));
            $contraseña      = main::encryption(main::limpiar_cadena($_POST['usuario_contraseña_reg']));

            if($nombre == "" || $primerapellido == "" || $numeroempleado == "" || $contraseña == ""){
                echo json_encode(['Alerta'=>'simple','Titulo'=>'Error','Texto'=>'No has llenado todos los campos obligatorios.','Tipo'=>'error']);
                exit();
            }

            if(main::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $nombre)){
                echo json_encode(['Alerta'=>'simple','Titulo'=>'Error','Texto'=>'El NOMBRE no coincide con el formato solicitado.','Tipo'=>'error']);
                exit();
            }
            if(main::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $primerapellido)){
                echo json_encode(['Alerta'=>'simple','Titulo'=>'Error','Texto'=>'El APELLIDO no coincide con el formato solicitado.','Tipo'=>'error']);
                exit();
            }
            if(main::verificar_datos("[a-zA-Z0-9]{1,35}", $numeroempleado)){
                echo json_encode(['Alerta'=>'simple','Titulo'=>'Error','Texto'=>'El NÚMERO DE EMPLEADO no coincide con el formato solicitado.','Tipo'=>'error']);
                exit();
            }

            // Verificar que el número de empleado no exista
            $check = main::ejecutar_consulta_simple("SELECT NumeroEmpleado FROM catcusuarios WHERE NumeroEmpleado='$numeroempleado'");
            if($check->rowCount() > 0){
                echo json_encode(['Alerta'=>'simple','Titulo'=>'Error','Texto'=>'El número de empleado ya está registrado en el sistema.','Tipo'=>'error']);
                exit();
            }

            $datos = [
                "Nombre"          => $nombre,
                "PrimerApellido"  => $primerapellido,
                "SegundoApellido" => $segundoapellido,
                "NumeroEmpleado"  => $numeroempleado,
                "Contraseña"      => $contraseña,
            ];

            $res = modeloUsuario::agregar_usuario_modelo($datos);

            echo json_encode($res->rowCount() == 1
                ? ['Alerta'=>'limpiar','Titulo'=>'Usuario registrado','Texto'=>'Los datos del usuario han sido registrados con éxito.','Tipo'=>'success']
                : ['Alerta'=>'simple', 'Titulo'=>'Error',             'Texto'=>'No se pudo registrar el usuario.',                     'Tipo'=>'error']
            );
        }

        // ──────────────────────────────────────────
        //  ELIMINAR USUARIO
        // ──────────────────────────────────────────
        public function eliminar_usuario_controlador(){
            $id = main::limpiar_cadena(main::decryption($_POST['usuario_id_del']));

            if($id == 1){
                echo json_encode(['Alerta'=>'simple','Titulo'=>'Error','Texto'=>'No se puede eliminar el usuario principal del sistema.','Tipo'=>'error']);
                exit();
            }

            $check = main::ejecutar_consulta_simple("SELECT IdUsuario FROM catcusuarios WHERE IdUsuario='$id'");
            if($check->rowCount() <= 0){
                echo json_encode(['Alerta'=>'simple','Titulo'=>'Error','Texto'=>'El usuario no existe en el sistema.','Tipo'=>'error']);
                exit();
            }

            if(session_status() === PHP_SESSION_NONE){ session_start(['name'=>'SPM']); }
            if($_SESSION['privilegio_spm'] != 1){
                echo json_encode(['Alerta'=>'simple','Titulo'=>'Sin permisos','Texto'=>'No tienes los permisos para realizar esta operación.','Tipo'=>'error']);
                exit();
            }

            $res = modeloUsuario::eliminar_usuario_modelo($id);

            echo json_encode($res->rowCount() == 1
                ? ['Alerta'=>'recargar','Titulo'=>'Usuario eliminado','Texto'=>'El usuario ha sido eliminado exitosamente.','Tipo'=>'success']
                : ['Alerta'=>'simple',  'Titulo'=>'Error',            'Texto'=>'No se pudo eliminar el usuario.',          'Tipo'=>'error']
            );
        }

        // ──────────────────────────────────────────
        //  DATOS USUARIO
        // ──────────────────────────────────────────
        public function datos_usuaurio_controlador($tipo, $id){
            $tipo = main::limpiar_cadena($tipo);
            $id   = main::limpiar_cadena(main::decryption($id));
            return modeloUsuario::datos_usuaurio_modelo($tipo, $id);
        }

    }