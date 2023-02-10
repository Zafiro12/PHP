<?php
require "config_bd.php";


function conexion_pdo(): array
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $respuesta["mensaje"] = "Conexi&oacute;n a la BD realizada con &eacute;xito";

        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function login($datos): array
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $sentencia = $sentencia->fetch(PDO::FETCH_ASSOC);

            if (count($sentencia) == 1) {
                $usuario = array($sentencia["usuario"], $sentencia["clave"]);
                $respuesta["usuario"] = $usuario;
            } else {
                $respuesta["mensaje"] = "Usuario no se encuentra registrado en la BD";
            }
        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}


function horario_usuario($id_usuario): array
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM horario_lectivo WHERE usuario = ?";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute(array($id_usuario));

            $sentencia = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            if (count($sentencia) > 0) {
                $respuesta["horario"] = $sentencia;
            } else {
                $respuesta["mensaje"] = "No hay horario en la BD";
            }
        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function usuarios_normales(): array
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM usuarios WHERE tipo = 'normal'";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();

            $sentencia = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            if (count($sentencia) > 0) {
                $respuesta["usuarios"] = $sentencia;
            } else {
                $respuesta["mensaje"] = "No hay usuarios en la BD";
            }
        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function tiene_grupo($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM horario_lectivo WHERE dia = ? AND hora = ? AND usuario = ?";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $sentencia = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            if (count($sentencia) > 0) {
                $respuesta["tiene_grupo"] = true;
            } else {
                $respuesta["tiene_grupo"] = false;
            }
        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}
