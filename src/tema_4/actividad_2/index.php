<?php
const URL = "http://localhost/tema_4/actividad_1/servicio/";

function consumir_servicios_REST($url, $metodo, $datos = null): bool|string
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
    header("Location: index.php");
}

if (isset($_GET["ver"])) {
    $cod = $_GET["ver"];
    $verProducto = json_decode(consumir_servicios_REST(URL . "/producto/" . $cod, "GET"))->producto;
    if (!$verProducto) {
        die("Error de conexión a los servicios.");
    }
} else {
    $listado = json_decode(consumir_servicios_REST(URL . "/productos", "GET"));
    if (!$listado) {
        die("Error de conexión a los servicios.");
    }
}


?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD - SW</title>
    <style>
        table, tr, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
        }
    </style>
</head>
<body>
<h1>Listado de productos</h1>
<?php
if (isset($listado)) {
    ?>
    <table>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>PVP</th>
            <th colspan="2">Acciones</th>
        </tr>
        <?php

        foreach ($listado->productos as $verProducto) {
            echo "<tr>";
            echo "<td><a href='index.php?ver=" . $verProducto->cod . "'>" . $verProducto->cod . "</a></td>";
            echo "<td>" . $verProducto->nombre_corto . "</td>";
            echo "<td>" . $verProducto->PVP . "</td>";
            echo "<td><a href='index.php?editar=" . $verProducto->cod . "'>Editar</a></td><td><a href='index.php?borrar=" . $verProducto->cod . "'>Eliminar</a></td>";
            echo "</tr>";
        }

        ?>
    </table>
    <?php
} else if (isset($verProducto)) {
    ?>
    <table style="width: 500px;">
        <?php
        echo "<tr>";
        echo "<th>Código</th><td>" . $verProducto->cod . "</td></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<th>Nombre</th><td>" . $verProducto->nombre_corto . "</td></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<th>Descripción</th><td>" . $verProducto->descripcion . "</td></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<th>PVP</th><td>" . $verProducto->PVP . "</td></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<th>Familia</th><td>" . $verProducto->familia . "</td></td>";
        echo "</tr>";
        ?>
    </table>
    <button>
        <a style="text-decoration: none; color: black" href="index.php?salir=1">Volver</a>
    </button>

    <?php
}
?>
</body>
</html>
