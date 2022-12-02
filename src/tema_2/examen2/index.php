<?php
session_start();

if (isset($_POST['usuario'])) {
    session_destroy();
    session_start();
    $_SESSION['id_usuario'] = $_POST['usuario'];
}

if (isset($_GET['dia']) && isset($_GET['hora'])) {
    $_SESSION['dia'] = $_GET['dia'];
    $_SESSION['hora'] = $_GET['hora'];
}

require_once 'src/config.php';

if (isset($_GET['id_horario'])) {
    // Eliminar de la base de datos horario_lectivo
    $sql = "DELETE FROM horario_lectivo WHERE id_horario = '" . $_GET['id_horario'] . "'";
    $accionExitosa = mysqli_query($link, $sql);
}

if (isset($_POST['dia']) && isset($_POST['hora']) && isset($_POST['grupo'])) {
    // Añadir a la base de datos horario_lectivo
    $sql = "INSERT INTO horario_lectivo (usuario, dia, hora, grupo, aula) VALUES ('" . $_SESSION['id_usuario'] . "', '" . $_POST['dia'] . "', '" . $_POST['hora'] . "', '" . $_POST['grupo'] . "', 'Aula no especificada')";
    $accionExitosa = mysqli_query($link, $sql);
}

function entablarHorario($link, $id_usuario)
{
    /*El horario de la base de datos viene con una columna para el día, otra para la hora, otra para el id del grupo*/
    $sql = "SELECT * FROM horario_lectivo WHERE usuario = $id_usuario";
    $result = mysqli_query($link, $sql);
    $horario = array();
    $aux = true;
    if (mysqli_num_rows($result) > 0) { // LA HORA VA DESDE 1 A 7
        while ($row = mysqli_fetch_assoc($result)) {
            if (isset($horario[$row['dia']][$row['hora']-1])) {
                @$horario[$row['dia']][$row['hora']-1] .= " " . $row['grupo'];
            } else {
                $horario[$row['dia']][$row['hora']-1] = $row['grupo'];
            }
        }
    } else {
        $aux = false;
    }
    mysqli_free_result($result);

    $sql = "SELECT nombre FROM usuarios WHERE id_usuario = $id_usuario";
    $result = mysqli_query($link, $sql);
    $nombre = mysqli_fetch_assoc($result)['nombre'];
    mysqli_free_result($result);

    $tabla = "<h3>Horario del profesor " . $nombre . "</h3>";
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
                                    $tabla .= " " . $row['nombre'];
                                }
                                mysqli_free_result($result);
                            }
                        }
                        $tabla .= "<br><a href='index.php?dia=$j&hora=$i'>Editar</a></td>";
                    } else {
                        $tabla .= "<td><a href='index.php?dia=$j&hora=$i'>Añadir</a></td>";
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
    if (isset($_SESSION['id_usuario'])) {
        echo entablarHorario($link, $_SESSION['id_usuario']);
    }
    
    if (isset($_SESSION['dia']) && isset($_SESSION['hora'])) {
        $dia = $_SESSION['dia'];
        $hora = $_SESSION['hora']+1;
        if ($_SESSION['hora'] < 3) {
            $horaBonita = $_SESSION['hora'] + 1;
        } else {
            $horaBonita = $_SESSION['hora'];
        }
        $diasLetras = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes");

        echo "<h3>Editando la " . $horaBonita . "ª hora del " . $diasLetras[$dia - 1] . "</h3>";
        if (isset($accionExitosa) && $accionExitosa) {
            echo "<p>Acción realizada con éxito</p>";
        } else if (isset($accionExitosa) && !$accionExitosa) {
            echo "<p>Ha habido un error</p>";
        }
        echo "<table border='1' style='text-align: center;'>";
        echo "<tr><th>Grupo</th><th>Accion</th></tr>";
        // coger nombre de la tabla grupos y id_horario de la tabla horario_lectivo
        $sql = "SELECT grupos.nombre, horario_lectivo.id_horario FROM grupos INNER JOIN horario_lectivo ON grupos.id_grupo = horario_lectivo.grupo WHERE horario_lectivo.dia = $dia AND horario_lectivo.hora = $hora AND horario_lectivo.usuario = " . $_SESSION['id_usuario'];
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row['nombre'] . "</td><td><a href='index.php?id_horario=" . $row['id_horario'] . "'>Quitar</a></td></tr>";
        }
        
        mysqli_free_result($result);
        echo "</table>";

        echo "<form action='index.php' method='post'>";
        echo "<label for='grupo'>Añadir grupo:</label>";
        echo "<select name='grupo' id='grupo'>";
        $sql = "SELECT * FROM grupos WHERE id_grupo NOT IN (SELECT grupo FROM horario_lectivo WHERE usuario = " . $_SESSION['id_usuario'] . " AND dia = $dia AND hora = $hora)";
        $result = mysqli_query($link, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['id_grupo'] . "'>" . $row['nombre'] . "</option>";
        }
        mysqli_free_result($result);
        echo "</select>";
        echo "<input type='hidden' name='dia' value='$dia'>";
        echo "<input type='hidden' name='hora' value='$hora'>";
        echo "<input type='submit' value='Añadir'>";
    }
    ?>
</body>
</html>