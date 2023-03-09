<?php
$url = URL_BASE . "/logueado";

$respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
$obj = json_decode($respuesta);

if (!$obj) {
    $url = URL_BASE . "/salir";
    consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);
    session_destroy();
    error_page("ERROR", "Error al consumir los servicios", $respuesta);
    exit;
}

if (isset($obj->error)) {
    $url = URL_BASE . "/salir";
    consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);
    session_destroy();
    error_page("ERROR", "Error al acceder a la base de datos", $obj->error);
    exit;
}

if (isset($obj->mensaje)) {
    session_unset();
    $_SESSION["seguridad"] = "Has sido baneado";
    header("Location: " . $salto);
    exit;
} 

if (isset($obj->no_auth)) {
    session_unset();
    $_SESSION["seguridad"] = "La API ha caducado";
    header("Location: " . $salto);
    exit;
} else {
    $datos_usuario = $obj->usuario;

    if ($_SESSION["ultimo_acceso"] - time() > MIN * 60) {
        $url = URL_BASE . "/salir";
        consumir_servicios_REST($url, "POST", $_SESSION["api_session"]);
        session_unset();
        $_SESSION["seguridad"] = "La sesión ha caducado";
        header("Location: " . $salto);
        exit;
    }

    $_SESSION["ultimo_acceso"] = time();
}
