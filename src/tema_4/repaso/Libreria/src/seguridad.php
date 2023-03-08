<?php
// seguridad
$url = URL_BASE . "/logueado";
$datos = $_SESSION["key"];

$respuesta = consumir_servicios_REST($url, "GET", $datos);
$obj = json_decode($respuesta);

if (!$obj) {
    consumir_servicios_REST(URL_BASE . "/salir", "POST", $_SESSION["key"]);
    session_destroy();
    die("<p>Error en la respuesta del servidor</p>");
}

if (isset($obj->error)) {
    consumir_servicios_REST(URL_BASE . "/salir", "POST", $_SESSION["key"]);
    session_destroy();
    die("<p>Error: " . $obj->error . "</p>");
}

if (isset($obj->no_auth)) {
    session_unset();
    $_SESSION["seguridad"] = "No tienes permisos para usar este servicio";
    header("Location: " . $salto);
    exit();
}

$usuario = $obj->usuario;

if ($_SESSION["ultimo_acceso"]>MINUTOS*60) {
    session_unset();
    $_SESSION["seguridad"] = "Sesión caducada";
    header("Location: " . $salto);
    exit();
}