<?php
require "config_bd.php";

function conexion_pdo()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
        
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}


function login($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";

        try {
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if ($sentencia->rowCount()>0) {
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
                session_name("API_REC_SW_22_23");
                session_start();
                $_SESSION["usuario"]=$respuesta["usuario"];
                $respuesta["api_session"] = session_id();
            } else {
                $respuesta["mensaje"]="Usuario no se encuentra regis. en la BD";
            }


            $conexion=null;
        } catch (PDOException $e) {
            $respuesta["error"]="Error en la consulta:".$e->getMessage();
        }
        
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function logueado($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND clave=?";

        try {
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if ($sentencia->rowCount()>0) {
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
            } else {
                $respuesta["mensaje"]="Usuario no se encuentra regis. en la BD";
            }


            $conexion=null;
        } catch (PDOException $e) {
            $respuesta["error"]="Error en la consulta:".$e->getMessage();
        }
        
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function usuario($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        $consulta = "SELECT * FROM usuarios WHERE id_usuario=?";

        try {
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if ($sentencia->rowCount()>0) {
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
            } else {
                $respuesta["mensaje"]="Usuario no se encuentra regis. en la BD";
            }


            $conexion=null;
        } catch (PDOException $e) {
            $respuesta["error"]="Error en la consulta:".$e->getMessage();
        }
        
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function usuariosGuardia($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        $consulta = "SELECT id_usuario,u.usuario,nombre,clave,email FROM usuarios u, horario_guardias h WHERE u.id_usuario = h.usuario AND dia=? and hora=?";

        try {
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);

            $conexion=null;
        } catch (PDOException $e) {
            $respuesta["error"]="Error en la consulta:".$e->getMessage();
        }
        
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function deGuardia($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        $consulta = "SELECT * FROM horario_guardias WHERE dia=? and hora=? and usuario=?";

        try {
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if ($sentencia->rowCount()>0) {
                $respuesta["de_guardia"]= true;
            } else {
                $respuesta["de_guardia"]=false;
            }

            $conexion=null;
        } catch (PDOException $e) {
            $respuesta["error"]="Error en la consulta:".$e->getMessage();
        }
        
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}