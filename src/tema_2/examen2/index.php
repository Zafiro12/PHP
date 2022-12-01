<?php
session_start();
require_once 'src/config.php';

function entablarHorario($link, $id_usuario)
{
    /*El horario de la base de datos viene con una columna para el día, otra para la hora, otra para el id del grupo*/
    $sql = "SELECT * FROM horario_lectivo WHERE usuario = $id_usuario";
    $result = mysqli_query($link, $sql);
    $horario = array();
    $aux = true;
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (isset($horario[$row['dia']][$row['hora']])) {
                $horario[$row['dia']][$row['hora']] .= " " . $row['grupo'];
            } else {
                $horario[$row['dia']][$row['hora']] = $row['grupo'];
            }
        }
    } else {
        $aux = false;
    }
    mysqli_free_result($result);

    $tabla = "<h3>Horario del profesor nº" . $_SESSION['id_usuario'] . "</h3>";
    $arrayHoras = array("8:15 - 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:15 - 11:45", "11:45 - 12:45", "12:45 - 13:45", "13:45 - 14:45");

    if ($aux) {
        $tabla .= "<table border='1' style='text-align: center;'>";
        $tabla .= "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
        for ($i = 0; $i < count($arrayHoras); $i++) {
            $tabla .= "<tr><th>" . $arrayHoras[$i] . "</th>";
            if ($arrayHoras[$i] == "11:15 - 11:45") {
                $tabla .= "<td colspan='5'>Recreo</td>";
            } else {
                for ($j = 1; $j <= 5; $j++) {
                    if (isset($horario[$j][$i])) {
                        $hora = explode(" ", $horario[$j][$i]);
                        $tabla .= "<td>";
                        for ($k = 0; $k < count($hora); $k++) {
                            $sql = "SELECT nombre FROM grupos WHERE id_grupo = " . $hora[$k];

                            if ($result = mysqli_query($link, $sql)) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $tabla .= " ".$row['nombre'];
                                }
                                mysqli_free_result($result);
                            }
                        }
                        $tabla .= "<br><a href='#'>Editar</a></td>";
                    } else {
                        $tabla .= "<td><a href='#'>Editar</a></td>";
                    }
                }
            }
            $tabla .= "</tr>";
        }
        $tabla .= "</table>";
    } else {
        $tabla .= "<p>El profesor no tiene horario</p>";
    }

    return $tabla;
}



if (isset($_POST['usuario'])) {
    $_SESSION['id_usuario'] = $_POST['usuario'];
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 PHP</title>
</head>

<body>
    <h1>Examen2 PHP</h1>
    <h2>Horario de los Profesores</h2>
    <form action="index.php" method="post">
        <label for="profesor">Horario del profesor:</label>
        <select name="usuario" id="profesor">
            <?php
            $sql = "SELECT * FROM usuarios";
            $result = mysqli_query($link, $sql);
            while ($row = mysqli_fetch_array($result)) {
                if ($row['id_usuario'] == $_SESSION['id_usuario']) {
                    echo "<option value='" . $row['id_usuario'] . "' selected>" . $row['nombre'] . "</option>";
                } else {
                    echo "<option value='" . $row['id_usuario'] . "'>" . $row['nombre'] . "</option>";
                }
            }
            mysqli_free_result($result);
            ?>
        </select>
        <input type="submit" value="Ver horario">
    </form>
    <?php
    echo entablarHorario($link, $_SESSION['id_usuario']);
    ?>
</body>

</html>