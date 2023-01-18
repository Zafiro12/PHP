<?php
const HOST = 'db';
const USER = 'jose';
const PASSWORD = 'josefa';
const DB = 'bd_blog';

function pagina_error($error)
{
    echo "<!DOCTYPE html>
    <html lang='es'>
    
    <head>
        <meta charset='UTF-8'>
        <title>Error</title>
    </head>
    
    <body>
        <h1>Ha ocurrido un error</h1>
        <p>" . $error . "</p>
    </body>
    
    </html>";
    exit();
}

function ejecutar_consulta(string $consulta, ?array $array = [])
{
    $sentencia = false;

    try {
        $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PASSWORD);

        if (count($array) > 0) {
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($array);
        } else {
            $sentencia = $conexion->query($consulta);
        }
    } catch (PDOException $e) {
        pagina_error($e->getMessage());
    }

    return $sentencia;
}