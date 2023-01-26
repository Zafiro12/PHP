<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXAMEN 2 DWESE</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .boton {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php
    @$link = mysqli_connect("db", "jose", "josefa", "bd_exam_colegio");
    if (!$link) {
        echo "<h1>Error: No se pudo conectar a MySQL.</h1>" . PHP_EOL;
        echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
        echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
        exit;
    } else {
        if (isset($_GET["borrar"])) {
            $cod_alu = $_GET["cod_alu"];
            $cod_asig = $_GET["cod_asig"];

            $sql = "DELETE FROM notas WHERE cod_alu = $cod_alu AND cod_asig = $cod_asig";
            if ($result = mysqli_query($link, $sql)) {
                $error_borrado = false;
            } else {
                $error_borrado = true;
            }
        }

        if (isset($_GET["editar"])) {
            $_SESSION["cod_alu"] = $_GET["cod_alu"];
            $_SESSION["cod_asig"] = $_GET["cod_asig"];
        }

        if (isset($_GET["cambiar"])) {
            session_destroy();
            $cod_alu = $_GET["cod_alu"];
            $cod_asig = $_GET["cod_asig"];
            $nota = $_GET["nota"];

            $sql = "UPDATE notas SET nota = $nota WHERE cod_alu = $cod_alu AND cod_asig = $cod_asig";
            if ($result = mysqli_query($link, $sql)) {
                $error_edicion = false;
            } else {
                $error_edicion = true;
            }
        }

        if (isset($_GET["insertar"])) {
            $cod_alu = $_GET["cod_alu"];
            $cod_asig = $_GET["cod_asig"];
            $nota = $_GET["nota"];

            if ($nota >= 0 && $nota <= 10 && $nota != "") {
                $sql = "INSERT INTO notas (cod_alu, cod_asig, nota) VALUES ($cod_alu, $cod_asig, $nota)";
                if ($result = mysqli_query($link, $sql)) {
                    $error_insertar = false;
                } else {
                    $error_insertar = true;
                }
            } else {
                $error_insertar = true;
            }
        }
    ?>
        <h1>Notas de los alumnos</h1>
        <?php
        if (isset($_GET['cod_alu'])) {
            $_POST['cod_alu'] = $_GET['cod_alu'];
        }
        $sql = "SELECT * FROM alumnos";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "<form method='POST' action='funciones.php'>";
            echo "<select name='cod_alu'>";
            while ($row = mysqli_fetch_assoc($result)) {
                if (isset($_POST['cod_alu']) && $_POST['cod_alu'] == $row['cod_alu']) {
                    echo "<option value='" . $row['cod_alu'] . "' selected>" . $row['nombre'] . "</option>";
                } else {
                    echo "<option value='" . $row['cod_alu'] . "'>" . $row['nombre'] . "</option>";
                }
            }
            mysqli_free_result($result);
            echo "</select>";
            echo "<input type='submit' value='Ver notas'>";
            echo "</form>";
        } else {
            echo "<p>En estos momentos no hay alumnos registrados en la BD.</p>";
        }

        if (isset($_POST['cod_alu'])) {
            $sql = "SELECT nombre FROM alumnos WHERE cod_alu = " . $_POST['cod_alu'];
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
            echo "<h2>Notas de " . $row['nombre'] . "</h2>";
            $nombreAlumno = $row['nombre'];
            mysqli_free_result($result);

            echo "<table>";
            echo "<tr>";
            echo "<th>Asignatura</th>";
            echo "<th>Nota</th>";
            echo "<th>Accion</th>";
            echo "</tr>";

            $sql = "SELECT * FROM notas WHERE cod_alu = " . $_POST['cod_alu'];
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    $sql = "SELECT denominacion FROM asignaturas WHERE cod_asig = " . $row['cod_asig'];
                    $result2 = mysqli_query($link, $sql);
                    $row2 = mysqli_fetch_assoc($result2);
                    echo "<td>" . $row2['denominacion'] . "</td>";
                    mysqli_free_result($result2);
                    if (isset($_SESSION['cod_asig'])) {
                        if ($row['cod_asig'] == $_SESSION['cod_asig']) {
                            echo "<td><form method=GET action=funciones.php><input type='text' name='nota' value='" . $row['nota'] . "'>
                            <input type='hidden' name='cod_alu' value='" . $_POST['cod_alu'] . "'>
                            <input type='hidden' name='cod_asig' value='" . $row['cod_asig'] . "'>
                            </td>";
                            echo "<td><input type='submit' name='cambiar' value='Cambiar'>
                    <a href=funciones.php>ATRAS</a></form></td>";
                            echo "</tr>";
                        } else {
                            echo "<td>" . $row['nota'] . "</td>";
                            echo "<td><a href=funciones.php?cod_asig=" . $row['cod_asig'] . "&cod_alu=" . $row['cod_alu'] . "&editar=true>EDITAR</a> |
                    <a href=funciones.php?cod_asig=" . $row['cod_asig'] . "&cod_alu=" . $row['cod_alu'] . "&borrar=true>BORRAR</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<td>" . $row['nota'] . "</td>";
                        echo "<td><a href=funciones.php?cod_asig=" . $row['cod_asig'] . "&cod_alu=" . $row['cod_alu'] . "&editar=true>EDITAR</a> |
                    <a href=funciones.php?cod_asig=" . $row['cod_asig'] . "&cod_alu=" . $row['cod_alu'] . "&borrar=true>BORRAR</a></td>";
                        echo "</tr>";
                    }
                }
            }
            mysqli_free_result($result);
            if (isset($_POST['calificar'])) {
                $cod_asig = $_POST['cod_asig'];
                $sql = "SELECT denominacion FROM asignaturas WHERE cod_asig = $cod_asig";
                $result = mysqli_query($link, $sql);
                $row = mysqli_fetch_assoc($result);
                $denominacion = $row['denominacion'];
                mysqli_free_result($result);
                echo "<tr>";
                echo "<td>$denominacion</td>";
                echo "<td><form method=GET action=funciones.php><input type='text' name='nota'>
                <input type='hidden' name='cod_alu' value='" . $_POST['cod_alu'] . "'>
                <input type='hidden' name='cod_asig' value='" . $cod_asig . "'>
                </td>";
                echo "<td><input type='submit' name='insertar' value='Cambiar'>
                <a href=funciones.php>ATRAS</a></form></td>";
                echo "</tr>";
            }
            echo "</table>";

            if (isset($error_insercion) && $error_insercion == false) {
                echo "<p>Nota insertada correctamente.</p>";
            } else if (isset($error_insercion) && $error_insercion == true) {
                echo "<p>Ha ocurrido un error al insertar la nota.</p>";
            }

            if (isset($error_borrado) && $error_borrado == false) {
                echo "<p>Nota borrada correctamente.</p>";
            } else if (isset($error_borrado) && $error_borrado == true) {
                echo "<p>Ha ocurrido un error al borrar la nota.</p>";
            }

            $sql = "SELECT * FROM asignaturas WHERE cod_asig NOT IN (SELECT cod_asig FROM notas WHERE cod_alu = " . $_POST['cod_alu'] . ")";
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "<form method='POST' action='funciones.php'>";
                echo "<input type='hidden' name='cod_alu' value='" . $_POST['cod_alu'] . "'>";
                echo "<p>Asignaturas que a $nombreAlumno aún queda por calificar:</p>";
                echo "<select name='cod_asig'>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['cod_asig'] . "'>" . $row['denominacion'] . "</option>";
                }
                echo "</select>";
                mysqli_free_result($result);
                echo "</select>";
                echo "<input type='submit' name='calificar' value='Calificar'>";
                echo "</form>";
            } else {
                echo "<p>A $nombreAlumno no quedan asignaturas por calificar.</p>";
            }
        }
        ?>
    <?php
    }
    mysqli_close($link);
    ?>
</body>

</html>