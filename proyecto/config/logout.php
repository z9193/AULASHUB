<?php
    // Incluimos el servidor para tener la SERVERURL
    require_once "SERVER.php";

    session_name("SPM"); // Muy importante usar el nombre SPM
    session_start();
    session_destroy();

    // Redireccionamos a la URL base (donde está el login)
    header("Location: ".SERVERURL."login/");
    exit();