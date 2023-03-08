<?php
require "src/funciones.php";

session_name("Exam_SW_22_23");
session_start();

const URL_BASE = "http://localhost/tema_4/repaso/servicios_rest";
const MINUTOS = 5;

$salto = "index.php";


if (isset($_SESSION["usuario"])) {
    require "src/seguridad.php";
    if ($usuario->tipo == "admin") {
        header("Location: admin/index.php");
    } else {
        require "vistas/vista_usuario.php";
    }

} else {
    require "vistas/vista_login.php";
}
