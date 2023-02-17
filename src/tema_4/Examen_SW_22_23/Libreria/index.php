<?php
session_name("Exam_SW_22_23");
session_start();

require "admin/funciones.php";

if (isset($_POST["logout"])) {
    $url = DIR . "/salir";
    $respuesta = json_decode(consumir_servicios_REST($url, "POST", array(
        "api_session" => $_SESSION["api_session"]
    )), true);
    session_destroy();
    header("Location: index.php");
    exit();
}

if (isset($_SESSION["seguridad"])) {
    echo error_page("Mensaje", "Mensaje", $_SESSION["seguridad"]);
    unset($_SESSION["seguridad"]);
}

if (isset($_SESSION["usuario"])) {
    require "admin/seguridad.php";

    if ($datos_usuario->tipo == "normal") {
        require "vistas/vista_normal.php";
    } else if ($datos_usuario->tipo == "admin") {
        require "admin/index.php";
    }
} else {
    require "vistas/vista_login.php";
}
