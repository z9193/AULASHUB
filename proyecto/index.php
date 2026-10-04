<?php
    require_once "./config/configGen.php";
    require_once "./controladores/vistasC.php";

    $plantilla = new vistasC();
    $plantilla->obtenerPlantilla();
