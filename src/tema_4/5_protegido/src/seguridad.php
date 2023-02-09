<?php
define("MINUTOS",5);

$datos_segur["usuario"]=$_SESSION["usuario"];
$datos_segur["clave"]=$_SESSION["clave"];
$url=DIR_SERV."/login";
$respuesta=consumir_servicios_REST($url,"POST",$datos_segur);
$obj=json_decode($respuesta);
if(!$obj)
    die(error_page("Login SW","Login SW","<p>Error consumiendo el servicio: ".$url."</p>".$respuesta));

if(isset($obj->error))
    die(error_page("Login SW","Login SW","<p>".$obj->error."</p>"));

if(isset($obj->mensaje))
{
    session_unset();
    $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit;
}
else
{
    $datos_usuario_log=$obj->usuario;
}

if(time()-$_SESSION["ultimo_acceso"]>MINUTOS*60)
{
    session_unset();
    $_SESSION["seguridad"]="Su tiempo de sesión ha expirado";
    header("Location:index.php");
    exit;
}

$_SESSION["ultimo_acceso"]=time();
?>