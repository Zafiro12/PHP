<?php
require "config_bd.php";

function obtener_libros()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        try{
            $consulta="select * from libros";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute();
            $respuesta["libros"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar consulta:".$e->getMessage();
        }
        $sentencia=null;
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function repetido($tabla,$columna,$valor)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        try{
            $consulta="select ".$columna." from ".$tabla." where ".$columna."=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$valor]);
            $respuesta["repetido"]=$sentencia->rowCount()>0;
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar consulta:".$e->getMessage();
        }
        $sentencia=null;
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
        try{
            $consulta="select * from usuarios where lector=? and clave=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
            if($sentencia->rowCount()>0)
            {
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
                session_name("Exam_API_SW_22_23");
                session_start();
                $respuesta["api_session"]=session_id();
                $_SESSION["tipo"]=$respuesta["usuario"]["tipo"];
                $_SESSION["usuario"]=$respuesta["usuario"]["lector"];
                $_SESSION["clave"]=$respuesta["usuario"]["clave"];

            }
            else
            {
                $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD";
            }
            
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar consulta:".$e->getMessage();
        }
        $sentencia=null;
        $conexion=null;
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
        try{
            $consulta="select * from usuarios where lector=? and clave=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
            if($sentencia->rowCount()>0)
            {
                $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
            }
            else
            {
                $respuesta["mensaje"]="El usuario no se encuentra registrado en la BD";
            }
            
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar consulta:".$e->getMessage();
        }
        $sentencia=null;
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}
function insertar_libro($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        try{
            $consulta="insert into libros (referencia,titulo,autor,descripcion,precio) values (?,?,?,?,?)";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
            $respuesta["mensaje"]="El libro ha sido insertado con éxito en la BD";
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar consulta:".$e->getMessage();
        }
        $sentencia=null;
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}

function actualizar_portada($datos)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        try{
            $consulta="update libros set portada=? where referencia=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute($datos);
            $respuesta["mensaje"]="Portada cambiada correctamente en la BD";
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible realizar consulta:".$e->getMessage();
        }
        $sentencia=null;
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}
?>
