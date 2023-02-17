<?php
$url = DIR . "/login";
$datos["lector"] = $_SESSION["usuario"];
$datos["clave"] = $_SESSION["clave"];

$respuesta = json_decode(consumir_servicios_REST($url, "POST", $datos));

if (isset($respuesta->usuario)) {
    if (time() - $_SESSION["ultimo_acceso"] > MINUTOS * 60) {
        session_destroy();
        $_SESSION["seguridad"] = "Tiempo de sesión agotado";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION["ultimo_acceso"] = time();
        $_SESSION["api_session"] = $respuesta->api_session;
        $datos_usuario = $respuesta->usuario;
    }

} else {
    session_destroy();
    $_SESSION["seguridad"] = "Ya no tienes acceso a la aplicación";
    header("Location: index.php");
    exit();
}
