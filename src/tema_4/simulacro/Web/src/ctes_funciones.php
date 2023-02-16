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

function entablarHorario($usuario): string
{
    $url = DIR_SERV . "/horario/" . $usuario->id_usuario;
    $horario = json_decode(consumir_servicios_REST($url, "GET"));

    if (isset($horario->horario)) {
        $tabla = "<h2>Horario del profesor: " . $usuario->nombre . "</h2>";
        $tabla .= "<table border='1' style='border-collapse: collapse;text-align: center'>";
        $tabla .= "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
        for ($i = 0; $i < 7; $i++) {
            $tabla .= "<tr>";
            for ($j = 0; $j < 5; $j++) {

                $hora = match ($i) {
                    0 => "8:15-9:15",
                    1 => "9:15-10:15",
                    2 => "10:15-11:15",
                    3 => "11:15-11:45",
                    4 => "11:45-12:45",
                    5 => "12:45-13:45",
                    6 => "13:45-14:45"
                };

                if ($j == 0) {
                    $tabla .= "<td class='hora'>" . $hora . "</td>";
                } else if ($i == 3) {
                    $tabla .= "<td colspan='5'>RECREO</td>";
                    break;
                } else {
                    $tabla .= "<td>";
                    $url = DIR_SERV . "/grupos/" . $j + 1 . "/" . $i + 1 . "/" . $usuario->id_usuario;
                    $grupos = json_decode(consumir_servicios_REST($url, "GET"));

                    if ($grupos->grupos) {
                        foreach ($grupos->grupos as $grupo) {
                            $tabla .= $grupo[1] . "<br>";
                        }
                    }

                    $tabla .= "</td>";
                }
            }
            $tabla .= "</tr>";
        }
        $tabla .= "</table>";
    } else {
        $tabla = "<p>El profesor no tiene horario</p>";
    }

    return $tabla;
}

const DIR_SERV = "http://localhost/tema_4/simulacro/servicios_rest";
const MINUTOS = 10;
