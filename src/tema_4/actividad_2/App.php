<?php
function consumir_servicios_REST($url, $metodo, $datos=null) {
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