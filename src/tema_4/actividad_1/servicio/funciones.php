<?php
require "admin/config.php";

function productos()
{
    $consulta = "select * from producto";

    if ($resultado = ejecutar_consulta($consulta)) {
        return $resultado->fetchAll(PDO::FETCH_ASSOC);
    }

    return false;
}
