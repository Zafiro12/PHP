<?php
require "../tema_3/blog/admin/Conexion.php";
header('Access-Control-Allow-Origin: *');

$conexion = new Conexion("db", "bd_usuarios", "jose", "josefa");

$_POST = json_decode(file_get_contents("php://input"), true);

$sentencia = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?;";

$result = 0;

$sentencia = $conexion->conectar()->prepare($sentencia);
$sentencia->execute(array($_POST["usuario"], $_POST["clave"]));

if ($sentencia->rowCount()>0) {
    $r["mensaje"] = "aprobado";
} else {
    $r["mensaje"] = "denegado";
}


echo json_encode($r);