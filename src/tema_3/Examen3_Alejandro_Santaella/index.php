<?php
session_name("examen3_22_23");
session_start();
require_once "admin/config.php";

if (isset($_GET["salir"])) {
    session_unset();
}

if (isset($_SESSION["usuario"])) {
    if ($_SESSION["ultimo_acceso"] < (time() - 60*3)) {
        session_unset();
        header("Location: funciones.php");
        exit();
    }

    $consulta = "select * from clientes where usuario=? and clave=?";
    $resultado = ejecutar_consulta($consulta, array($_SESSION["usuario"], $_SESSION["clave"]))->fetch(PDO::FETCH_ASSOC);

    if ($resultado["tipo"] == "admin") {
        require_once "admin/gest_clientes.php";
    } else {
        require_once "vistas/cliente.php";
    }
} else {
    if (isset($_POST["registrarse"])) {
        require_once "vistas/registro.php";
    } else {
        require_once "vistas/login.php";
    }
}