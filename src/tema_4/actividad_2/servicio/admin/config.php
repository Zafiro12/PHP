<?php
const HOST = 'db';
const USER = 'jose';
const PASSWORD = 'josefa';
const DB = 'bd_tienda';

function ejecutar_consulta(string $consulta, ?array $array = []): bool|PDOStatement
{
    try {
        $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PASSWORD);

        if (count($array) > 0) {
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($array);
        } else {
            $sentencia = $conexion->query($consulta);
        }

        unset($conexion);
    } catch (PDOException) {
        $sentencia = false;
    }

    return $sentencia;
}