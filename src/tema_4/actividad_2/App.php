<?php
const URL = "http://localhost/tema_4/actividad_1/servicio/";

function consumir_servicios_REST($url, $metodo, $datos = null)
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
<table>
    <tr><th>Código</th><th>Nombre</th><th>PVP</th></tr>
    <?php
        $respuesta = json_decode(consumir_servicios_REST(URL."/productos", "GET"), true);
        foreach ($respuesta["productos"] as $producto) {
            echo "<tr>";
            echo "<td>" .$producto["cod"] . "</td>";
            echo "<td>" .$producto["nombre_corto"] . "</td>";
            echo "<td>" .$producto["PVP"] . "</td>";
            echo "</tr>";
        }
    ?>
</table>
</body>
</html>
