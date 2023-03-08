<?php
require "src/funciones.php";
session_name("Exam_SW_22_23");
session_start();
define("DIR_SERV","http://localhost/Proyectos/Examen_SW_22_23/servicios_rest");
$salto="index.php";

if(isset($_POST["btnSalir"]))
{
    session_destroy();
    header("Location:index.php");
    exit;
}



if(isset($_SESSION["usuario"]))//Si me he logueado
{
    //seguridad
    require "src/seguridad.php";
    if($datos_usu_log->tipo=="admin")
    {
        header("Location:admin/index.php");
    }
    else
        require "vistas/vista_normal.php";
}
else
{
    require "vistas/vista_login.php";
}
?>
