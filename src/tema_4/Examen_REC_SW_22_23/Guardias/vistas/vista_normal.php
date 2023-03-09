<?php
if (isset($_POST["equipo"])) {
    $_SESSION["equipo"] = $_POST["equipo"];
    $_SESSION["dia"] = $_POST["dia"];
    $_SESSION["hora"] = $_POST["hora"];
    $_SESSION["n_equipo"] = $_POST["n_equipo"];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Guardias</title>
</head>

<body>
    <h1>Gestion de Guardias</h1>
    <form action="index.php" method="post">
        <?php
        echo "<p>Bienvenido " . $datos_usuario->usuario;
        echo " - <input type='submit' name='salir' value='Salir'>";
        echo "</p>";
        ?>
    </form>

    <h2>Equipos de Guardia del IES Mar de Alborán</h2>
    <?php
    $horas[1] = "1º Hora";
    $horas[2] = "2º Hora";
    $horas[3] = "3º Hora";
    $horas[5] = "4º Hora";
    $horas[6] = "5º Hora";
    $horas[7] = "6º Hora";

    $dias[1] = "Lunes";
    $dias[2] = "Martes";
    $dias[3] = "Miercoles";
    $dias[4] = "Jueves";
    $dias[5] = "Viernes";

    echo "<table border='1' style='text-align: center;'>";
    $aux = 1;
    for ($i = 0; $i <= 7; $i++) {
        echo "<tr>";
        if ($i == 4) {
            echo "<td colspan='6'>Recreo</td>";
            continue;
        }
        for ($j = 0; $j <= 5; $j++) {
            if ($i == 0 && $j == 0) {
                echo "<th></th>";
            } else if ($i == 0) {
                echo "<th>" . $dias[$j] . "</th>";
            } else if ($j == 0) {
                echo "<td>" . $horas[$i] . "</td>";
            } else {
                $dia = $j;
                $hora = $i;
                if ($i > 4) {
                    $hora--;
                }

                echo "<td>";
                echo "<form action='index.php' method='post'>";
                echo "<input type='submit' value='Equipo" . $aux . "' name='equipo'>";
                echo "<input type='hidden' name='dia' value='" . $dia . "'>";
                echo "<input type='hidden' name='hora' value='" . $hora . "'>";
                echo "<input type='hidden' name='n_equipo' value='" . $aux . "'>";
                echo "</form>";
                echo "</td>";
                $aux++;
            }
        }
        echo "</tr>";
    }
    echo "</table>";

    if (isset($_SESSION["equipo"])) {
        $url = URL_BASE . "/usuariosGuardia/" . $_SESSION["dia"] . "/" . $_SESSION["hora"];
        $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            error_page("ERROR", "Error al consumir los servicios", $respuesta);
            exit;
        }

        if (isset($obj->error)) {
            session_destroy();
            error_page("ERROR", "Error al acceder a la base de datos", $obj->error);
            exit;
        }

        if (isset($obj->no_auth)) {
            session_unset();
            $_SESSION["seguridad"] = "La API ha caducado";
            header("Location: " . $salto);
            exit;
        }

        $url = URL_BASE . "/deGuardia/" . $_SESSION["dia"] . "/" . $_SESSION["hora"] . "/" . $datos_usuario->id_usuario;
        $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);
        $obj2 = json_decode($respuesta);

        if (!$obj2) {
            session_destroy();
            error_page("ERROR", "Error al consumir los servicios", $respuesta);
            exit;
        }

        if (isset($obj2->error)) {
            session_destroy();
            error_page("ERROR", "Error al acceder a la base de datos", $obj2->error);
            exit;
        }

        if (isset($obj2->no_auth)) {
            session_unset();
            $_SESSION["seguridad"] = "La API ha caducado";
            header("Location: " . $salto);
            exit;
        }

        $aux = $obj2->de_guardia;

        if ($aux) {
            echo "<h2>Equipo de guardia nº " . $_SESSION["n_equipo"] . "</h2>";
            $hora = $_SESSION["hora"];
            if ($_SESSION["hora"] >= 4) {
                $hora++;
            }
            echo "<h3>" . $dias[$_SESSION["dia"]] . " a ".$horas[$hora]."</h3>";
            echo "<table border='1' style='text-align: center;'>";
            echo "<tr>";
            echo "<th>Profesores de Guardia</th>";
            echo "<th>Info. del profesor de Guardia</th>";
            echo "</tr>";

            for ($i = 0; $i < count($obj->usuarios); $i++) {
                echo "<tr>";
                echo "<td>";
                echo "<form action='index.php' method='post'>";
                echo "<input type='submit' value='" . $obj->usuarios[$i]->usuario . "' name='info'>";
                echo "<input type='hidden' name='id_usuario' value='" . $obj->usuarios[$i]->id_usuario . "'>";
                echo "</form>";
                echo "</td>";
                if ($i == 0) {
                    echo "<td rowspan='" . count($obj->usuarios) . "'>";
                    if (isset($_POST["info"])) {
                        $url = URL_BASE . "/usuario/" . $_POST["id_usuario"];
                        $respuesta = consumir_servicios_REST($url, "GET", $_SESSION["api_session"]);

                        $obj1 = json_decode($respuesta);

                        if (!$obj1) {
                            session_destroy();
                            error_page("ERROR", "Error al consumir los servicios", $respuesta);
                            exit;
                        }

                        if (isset($obj1->error)) {
                            session_destroy();
                            error_page("ERROR", "Error al acceder a la base de datos", $obj1->error);
                            exit;
                        }

                        if (isset($obj1->no_auth)) {
                            session_unset();
                            $_SESSION["seguridad"] = "La API ha caducado";
                            header("Location: " . $salto);
                            exit;
                        }

                        echo "<p><strong>Nombre: </strong>" . $obj1->usuario->nombre . "</p>";
                        echo "<p><strong>Usuario: </strong>" . $obj1->usuario->usuario . "</p>";
                        echo "<p><strong>Contraseña: </strong></p>";
                        echo "<p><strong>Correo: </strong>";
                        if (isset($obj1->usuario->email)) {
                            echo $obj1->usuario->email;
                        } else {
                            echo "No tiene correo";
                        }
                        echo "</p>";
                    }
                }
                echo "</tr>";
            }

            echo "</table>";
        } else {
            $hora = $_SESSION["hora"];
            if ($_SESSION["hora"] >= 4) {
                $hora++;
            }
            echo "<h2>No estás de guardia el " . $dias[$_SESSION["dia"]] . " a ".$horas[$hora]."</h2>";
        }
    }
    ?>
</body>

</html>