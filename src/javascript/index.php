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

header('Access-Control-Allow-Origin: *');

$_POST = json_decode(file_get_contents("php://input"), true);

$sentencia = "SELECT * FROM usuarios WHERE usuario = ? AND password = ?;";

$sentencia = ejecutar_consulta($sentencia,array($_POST["usuario"], $_POST["clave"]));

if ($sentencia->rowCount()>0) {
    $r["mensaje"] = "aprobado";
} else {
    $r["mensaje"] = "denegado";
}

echo json_encode($r);