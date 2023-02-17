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
            $consulta = "SELECT * FROM usuarios where lector=? AND clave=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute(array($datos["lector"], $datos["clave"]));

            if ($sentencia->rowCount() > 0) {
                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
                $respuesta["api_session"] = session_id();
            } else {
                $respuesta["mensaje"] = "El usuario no se encuentra en la BD";
            }
        } catch (PDOException $e) {
            $respuesta["error"] = "Error: " . $e->getMessage();
        }

        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function obtenerLibros(): array
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "SELECT * FROM libros";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();

            if ($sentencia->rowCount() > 0) {
                $respuesta["libros"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $respuesta["mensaje"] = "No hay libros en la BD";
            }
        } catch (PDOException $e) {
            $respuesta["error"] = "Error: " . $e->getMessage();
        }

        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function crearLibro($datos): array
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "INSERT INTO libros (referencia, titulo, autor, descripcion, precio) VALUES (?, ?, ?, ?, ?)";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute(array($datos["referencia"], $datos["titulo"], $datos["autor"], $datos["descripcion"], $datos["precio"]));

            $respuesta["mensaje"] = "Libro insertado correctamente en la BD";
        } catch (PDOException $e) {
            $respuesta["error"] = "Error: " . $e->getMessage();
        }

        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function actualizarPortada($referencia,$datos): array
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        try {
            $consulta = "UPDATE libros SET portada=? WHERE referencia=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute(array($datos["portada"], $referencia));

            $respuesta["mensaje"] = "Portada actualizada correctamente en la BD";
        } catch (PDOException $e) {
            $respuesta["error"] = "Error: " . $e->getMessage();
        }

        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}
