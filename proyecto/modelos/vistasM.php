<?php 
class vistasM {

    protected static function obtModelo($vistas) {
        $blanco=["home","enlaces","departamentos","dispositivos","dep-enlaces","enlace-disp","enlace-lista",
        "departamentos-lista","dispositivos-lista", "departamentos-buscar","dispositivos-buscar","enlace-buscar","registro", "logout", "dispositivo-buscar",
        "dispositivo-lista", "nodo"];

        if(in_array($vistas, $blanco)) {
        if(is_file("./vistas/contenido/".$vistas."-view.php")){
            $contenido="./vistas/contenido/".$vistas."-view.php";
            }
            else{ $contenido="404";}
        
            

        }
        elseif ($vistas== "login" || $vistas== "index") {
            $contenido= "login";
        } else {
            $contenido= "404";
            
            
        } 
        return $contenido;

    }
}