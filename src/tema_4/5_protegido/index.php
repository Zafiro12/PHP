<?php
require "src/funciones.php";
const DIR_SERV = "http://localhost/tema_4/actividad_3/login_restful/";

session_name("Login_SW_22_23");
session_start();

if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:index.php");
    exit;
}


if (isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["ultimo_acceso"])) {

    require "src/seguridad.php";

    if ($datos_usuario_log->tipo == "admin")
        require "vistas/vista_admin.php";
    else
        require "vistas/vista_normal.php";
} else {

    require "vistas/vista_login.php";
}
