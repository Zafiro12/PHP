<?php
$url = DIR_SERV . "/login";
$datos_login["usuario"] = $_SESSION["usuario"];
$datos_login["clave"] = $_SESSION["clave"];

$obj = getObj($url, $datos_login);

if (isset($obj->usuario)) {
    if (time() - $_SESSION["ultimo_acceso"] > MINUTOS * 60) {
        session_unset();
        $_SESSION["seguridad"] = "Su tiempo de sesión ha caducado. Vuelva a loguearse o registrarse";
        header("Location:index.php");
        exit;
    }
} else {
    session_unset();
    $_SESSION["seguridad"] = "Zona restringida. Vuelva a loguearse o registrarse";
    header("Location:index.php");
    exit;
}

$_SESSION["ultimo_acceso"] = time();
$datos_usuario_log = $obj->usuario;
