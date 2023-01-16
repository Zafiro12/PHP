<?php
require_once "admin/clases/Usuarios.php";
$conexion = new Conexion(HOST,DB,USER,PASSWORD);
$usuarios = new Usuarios($conexion->conectar());

if (!$usuarios->comprobar($_SESSION["usuario"], $_SESSION["clave"])) {
    session_unset();
}

if (time()-$_SESSION["ultimo_acceso"] > 5*60) {
    session_unset();
}