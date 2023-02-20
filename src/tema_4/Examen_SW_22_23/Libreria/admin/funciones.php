<?php
const DIR = "http://localhost/tema_4/Examen_SW_22_23/servicios_rest"; // TODO: Cambiar por la dirección del servidor
const MINUTOS = 2;

function consumir_servicios_REST($url, $metodo, $datos = null): bool|string
{
    $llamada = curl_init();
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
    if (isset($datos))
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
    $respuesta = curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

function error_page($title, $cabecera, $mensaje): string
{
    $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html .= '<title>' . $title . '</title></head>';
    $html .= '<body><h1>' . $cabecera . '</h1>' . $mensaje . '</body></html>';
    return $html;
}

function getLibros()
{
    $url = DIR . "/obtenerLibros";
    $respuesta = json_decode(consumir_servicios_REST($url, "GET"), true);
    if (isset($respuesta["error"])) {
        echo error_page("Error", "Error al obtener los libros", $respuesta["error"]);
        return false;
    }

    foreach ($respuesta["libros"] as $libro) {
        echo "<div style='width: calc(100vw / 3 - 50px); margin: 10px;'>";
        echo "<img src='images/" . $libro["portada"] . "' alt='Imagen del libro " . $libro["titulo"] . "' width='100' height='100'>";
        echo "<h3>" . $libro["titulo"] . "</h3>";
        echo "<p>" . $libro["precio"] . " euros</p>";
        echo "</div>";
    }
}
