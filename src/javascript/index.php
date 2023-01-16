<?php
require "../tema_3/blog/admin/conexion.php";

$conexion = new Conexion("db", "bd_usuarios", "jose", "josefa");

$_POST = json_decode(file_get_contents("php://input"), true);

$sentencia = "SELECT * FROM usuarios WHERE usuario = ? AND clave = ?;";

$result = 0;

$sentencia = $conexion->conectar()->prepare($sentencia);
$sentencia->execute(array($_POST["usuario"], md5($_POST["clave"])));

if ($sentencia->rowCount()>0) {
    $r["mensaje"] = "aprobado";
} else {
    $r["mensaje"] = "denegado";
}
$r["cuenta"] = $sentencia->rowCount();
header('Access-Control-Allow-Origin: *');
echo json_encode($r);