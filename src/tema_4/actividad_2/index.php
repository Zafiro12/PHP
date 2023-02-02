<?php
session_name("CRUD");
session_start();

const URL = "http://localhost/tema_4/actividad_1/servicio/";

function consumir_servicios_REST(string $url, string $metodo, array $datos = null): bool|string
{
    $llamada = curl_init();
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
    if (isset($datos)) {
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
    }
    $respuesta = curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

if (isset($_GET["salir"])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

if (isset($_GET["ver"])) {
    $cod = $_GET["ver"];
    $producto = json_decode(consumir_servicios_REST(URL . "producto/" . $cod, "GET"))->producto;
    if (!$producto) {
        die("Error de conexión a los servicios.");
    }
}

if (isset($_GET["insertar"])) {
    $_SESSION["insertar"] = $_GET["insertar"];
}

if (isset($_SESSION["insertar"])) {
    require_once "views/insertar.php";
}

if (isset($_GET["borrar"])) {
    require_once "views/borrar.php";
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD - SW</title>
    <style>
        * {
            box-sizing: border-box;
        }

        table, tr, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
<h1>Listado de productos</h1>
<?php
if (isset($producto)) {
    require_once "views/producto.php";
}
$listado = json_decode(consumir_servicios_REST(URL . "productos", "GET"));
if (!$listado) {
    die("Error de conexión a los servicios.");
}
?>
<table>
    <tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>PVP</th>
        <th colspan="2"><a href="index.php?insertar=1">+Producto</a></th>
    </tr>
    <?php

    foreach ($listado->productos as $producto) {
        echo "<tr>";
        echo "<td><a href='index.php?ver=" . $producto->cod . "'>" . $producto->cod . "</a></td>";
        echo "<td>" . $producto->nombre_corto . "</td>";
        echo "<td>" . $producto->PVP . "</td>";
        echo "<td><a href='index.php?editar=" . $producto->cod . "'>Editar</a></td><td><a href='index.php?borrar=" . $producto->cod . "'>Eliminar</a></td>";
        echo "</tr>";
    }

    ?>
</table>

</body>
</html>
