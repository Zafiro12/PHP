<?php
    define("MINUTOS",2);
    $url=DIR_SERV."/logueado";
    $respuesta=consumir_servicios_REST($url,"GET",$_SESSION["key"]);
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["key"]);
        session_destroy();
        die(error_page("Examen Librería","Librería","<p>Error consumiendo el servicio".$url."</p>".$respuesta));
    }
    
    if(isset($obj->error))
    {
        consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["key"]);
        session_destroy();
        die(error_page("Examen Librería","Librería","<p>".$obj->error."</p>"));
    }

    if(isset($obj->no_auth))
    {
        session_unset();
        $_SESSION["seguridad"]="El tiempo de sesión de la API ha expirado";
        header("Location:".$salto);
        exit;
    }
    $datos_usu_log=$obj->usuario;
    
    if(time()-$_SESSION["ultimo_acceso"]>MINUTOS*60)
    {

        consumir_servicios_REST(DIR_SERV."/salir","POST",$_SESSION["key"]);
        session_unset();
        $_SESSION["seguridad"]="Su tiempo de sesión ha caducado. Vuelva a loguearse o registrarse";
        header("Location:".$salto);
        exit;
    }
    $_SESSION["ultimo_acceso"]=time();
?>