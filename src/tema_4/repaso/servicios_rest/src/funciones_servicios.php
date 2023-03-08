<?php
require "config_bd.php";

function obtener_libros()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $consulta = "SELECT * FROM libros";
        try {
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();

            $respuesta["libros"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["error"] = "Error al ejecutar la consulta:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function login($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $consulta = "SELECT * FROM usuarios WHERE lector=? AND clave=?";
        try {
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if ($sentencia->rowCount() > 0) {
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

                // Seguridad
                session_name("Exam_API_SW_22_23");
                session_start();

                $respuesta["api_session"] = session_id();

                $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
                $_SESSION["usuario"] = $respuesta["usuario"]["lector"];
                $_SESSION["clave"] = $respuesta["usuario"]["clave"];
            } else {
                $respuesta["mensaje"] = "Usuario no se encuentra regis. en la BD";
            }

            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["error"] = "Error al ejecutar la consulta:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function logueado($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $consulta = "SELECT * FROM usuarios WHERE lector=? AND clave=?";
        try {
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if ($sentencia->rowCount() > 0) {
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
            } else {
                $respuesta["mensaje"] = "Usuario no se encuentra regis. en la BD";
            }

            $sentencia = null;
            $conexion = null;
        } catch (PDOException $e) {
            $respuesta["error"] = "Error al ejecutar la consulta:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}
