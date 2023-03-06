<?php
require "src/funciones.php";

session_name("Exam_SW_22_23");
session_start();

const URL_BASE = "http://localhost/tema_4/repaso/servicios_rest";
const MINUTOS = 5;

if(isset($_SESSION["usuario"])) {
    // seguridad
    $url = URL_BASE . "/logueado";
    $datos = $_SESSION["key"];

    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj = json_decode($respuesta);

    if (!$obj) {
        die("<p>Error en la respuesta del servidor</p>");
    }

    if (isset($obj->error)) {
        die("<p>Error: " . $obj->error . "</p>");
    }

} else {
    require "vistas/vista_login.php";
}
