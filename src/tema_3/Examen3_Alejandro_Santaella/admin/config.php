<?php
const SERVIDOR_BD = 'db';
const NOMBRE_BD = 'videoclub_exam';
const USUARIO_BD = 'jose';
const CLAVE_BD = 'josefa';

function pagina_error($error)
{
    echo "<h1>Error</h1>";
    echo "<p>$error</p>";
    exit();
}

function ejecutar_consulta($consulta, $array = [])
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        pagina_error($e->getMessage());
        return false;
    }
    if (count($array) > 0) {
        try {
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($array);
        } catch (PDOException $e) {
            pagina_error($e->getMessage());
            return false;
        }
        return $sentencia;
    } else {
        try {
            return $conexion->query($consulta);
        } catch (PDOException $e) {
            pagina_error($e->getMessage());
            return false;
        }
    }
}