<?php
require "../src/funciones.php";
session_name("Exam_SW_22_23");
session_start();
define("DIR_SERV","http://localhost/Proyectos/Examen_SW_22_23/servicios_rest");
$salto="../index.php";
if(isset($_SESSION["usuario"]))
{
    require "../src/seguridad.php";
    if($datos_usu_log->tipo=="normal")
    {
        header("Location:".$salto);
        exit;
    }
    else
        require "../vistas/vista_admin.php";
}
else
{
    header("Location:".$salto);
    exit;
}
?>