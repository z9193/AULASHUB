<?php
require_once "./modelos/vistasM.php";

class vistasC extends vistasM {

    public function obtenerPlantilla() {
        return require_once "./vistas/plantilla.php";
    }

    public function obtvistas() {
        if(isset($_GET["views"])){
            $ruta      = explode("/", $_GET["views"]);
            $respuesta = vistasM::obtModelo($ruta[0]);
        } else {
            $respuesta = "login";
        }
        return $respuesta;
    }
}