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

            if ($sentencia) {
                $respuesta["usuario"] = $sentencia;
            } else {
                $respuesta["mensaje"] = "Usuario no se encuentra registrado en la BD";
            }
        } catch (PDOException $e) {
            $respuesta["error"] = "Error:" . $e->getMessage();
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

            if ($sentencia){
                $respuesta["horario"] = $sentencia;
            } else {
                $respuesta["mensaje"] = "No hay horario en la BD";
            }
        } catch (PDOException $e) {
            $respuesta["error"] = "Error:" . $e->getMessage();
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

            if ($sentencia){
                $respuesta["usuarios"] = $sentencia;
            } else {
                $respuesta["mensaje"] = "No hay usuarios en la BD";
            }
        } catch (PDOException $e) {
            $respuesta["error"] = "Error:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function tiene_grupo($datos): array
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM horario_lectivo WHERE dia = ? AND hora = ? AND usuario = ?";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $sentencia = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            if ($sentencia){
                $respuesta["tiene_grupo"] = true;
            } else {
                $respuesta["tiene_grupo"] = false;
            }
        } catch (PDOException $e) {
            $respuesta["error"] = "Error:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function grupos($datos): array
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM grupos JOIN horario_lectivo ON grupos.id_grupo = horario_lectivo.grupo WHERE horario_lectivo.dia = ? AND horario_lectivo.hora = ? AND horario_lectivo.usuario = ?";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $sentencia = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            if ($sentencia){
                $grupos = [];
                foreach ($sentencia as $grupo) {
                    $grupo = array($grupo["id_grupo"], $grupo["nombre"]);
                    $grupos[] = $grupo;
                }
                $respuesta["grupos"] = $grupos;
            } else {
                $respuesta["grupos"] = false;
            }
        } catch (PDOException $e) {
            $respuesta["error"] = "Error:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function grupos_libres($datos): array
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM grupos JOIN horario_lectivo ON grupos.id_grupo = horario_lectivo.grupo WHERE horario_lectivo.dia = ? AND horario_lectivo.hora = ? AND NOT horario_lectivo.usuario = ?";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $sentencia = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            if ($sentencia){
                $grupos = [];
                foreach ($sentencia as $grupo) {
                    $grupo = array($grupo["id_grupo"], $grupo["nombre"]);
                    $grupos[] = $grupo;
                }
                $respuesta["grupos_libres"] = $grupos;
            } else {
                $respuesta["grupos"] = false;
            }
        } catch (PDOException $e) {
            $respuesta["error"] = "Error:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function borrar_grupo($datos): array
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "DELETE FROM horario_lectivo WHERE horario_lectivo.dia = ? AND horario_lectivo.hora = ? AND horario_lectivo.usuario = ? AND horario_lectivo.grupo = ?";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            $respuesta["mensaje"] = "Grupo borrado";
        } catch (PDOException $e) {
            $respuesta["error"] = "Error:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function insertar_grupo($datos): array
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "INSERT INTO horario_lectivo (dia, hora, usuario, grupo, aula) VALUES (?, ?, ?, ?,(SELECT aula FROM horario_lectivo WHERE dia = ? AND hora = ? AND usuario = ?))";

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute(array($datos[0], $datos[1], $datos[2], $datos[3], $datos[0], $datos[1], $datos[2]));

            $respuesta["mensaje"] = "Grupo insertado";
        } catch (PDOException $e) {
            $respuesta["error"] = "Error:" . $e->getMessage();
        }
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}
