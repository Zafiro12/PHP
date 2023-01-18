<?php
$consulta = "SELECT * FROM usuarios WHERE usuario = ? AND password = ?";
$sentencia = ejecutar_consulta($consulta, array($_SESSION["usuario"], $_SESSION["clave"]));
$usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    session_unset();
}

if (time()-$_SESSION["ultimo_acceso"] > 5*60) {
    session_unset();
}