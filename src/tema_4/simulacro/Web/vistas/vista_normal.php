<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 PHP</title>
    <style>
        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        .enlinea {
            display: inline
        }
    </style>
</head>
<body>
<h1>Examen4 PHP</h1>
<div>
    Bienvenido <strong><?php echo $_SESSION["usuario"]; ?></strong> -
    <form class="enlinea" method="post" action="index.php">
        <button class="enlace" name="btnCerrarSesion">Salir</button>
    </form>
</div>
<h2>Su horario</h2>
<?php
$url = DIR_SERV . "/horario/" . $datos_usuario_log->id_usuario;
$horario = json_decode(consumir_servicios_REST($url, "GET"));
if (isset($horario->horario)) {
    echo "<h2>Horario del profesor: " . $datos_usuario_log->nombre . "</h2>";
    echo "<table border='1'>";
    echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
    for ($i = 0; $i < 7; $i++) {
        $hora = match ($i) {
            0 => "8:15-9:15",
            1 => "9:15-10:15",
            2 => "10:15-11:15",
            3 => "11:15-11:45",
            4 => "11:45-12:45",
            5 => "12:45-13:45",
            6 => "13:45-14:45",
            default => "",
        };
        echo "<tr><td>" . $hora . "</td>";
        for ($j = 0; $j < 5; $j++) {
            echo "<td>";
            if ($horario->horario[$i]->dia + 1 === $i && $horario->horario[$i]->hora + 1 === $j) {
                echo $horario->horario[$i]->grupo;
            }
            echo "</td>";
        }
        echo "</tr>";
    }
} else {
    echo "<p>No tiene horario</p>";
}
?>
</body>
</html>
