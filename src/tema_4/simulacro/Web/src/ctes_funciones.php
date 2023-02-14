<?php
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

function error_page($title, $body): string
{
    $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html .= '<title>' . $title . '</title></head>';
    $html .= '<body>' . $body . '</body></html>';
    return $html;
}

function getObj(string $url, $datos_login): mixed
{
    $respuesta = consumir_servicios_REST($url, "POST", $datos_login);
    $obj = json_decode($respuesta);
    if (!$obj) {
        session_destroy();
        die(error_page("Examen4 PHP", "<h1>Examen4 PHP</h1><p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta));
    }
    if (isset($obj->error)) {
        session_destroy();
        die(error_page("Examen4 PHP", "<h1>Examen4 PHP</h1><p>" . $obj->error . "</p>"));
    }
    return $obj;
}

const DIR_SERV = "http://localhost/tema_4/simulacro/servicios_rest";
const MINUTOS = 10;
