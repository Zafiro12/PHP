<?php
session_name("EXAM_REC_SW_22_23");
session_start();

require "src/funciones.php";
$salto = "index.php";

if (isset($_POST["salir"])) {
    $url = URL_BASE . "/salir";
    consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);
    session_destroy();
    header("Location: " . $salto);
    exit;
}

if (isset($_SESSION["usuario"])) {
    require "src/seguridad.php";
    require "vistas/vista_normal.php";
} else {
    require "vistas/vista_login.php";
}
