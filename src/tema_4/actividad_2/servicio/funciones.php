<?php
require "admin/config.php";

function productos(): bool|array
{
    $consulta = "select * from producto";

    if ($resultado = ejecutar_consulta($consulta)) {
        $respuesta["productos"] = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $respuesta;
    }

    return false;
}

function producto($cod): bool|array
{
    $consulta = "select * from producto where cod=?";

    if ($resultado = ejecutar_consulta($consulta, array($cod))) {
        $respuesta["producto"] = $resultado->fetch(PDO::FETCH_ASSOC);
        return $respuesta;
    }

    return false;
}