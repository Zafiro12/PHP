<?php
// Incluir archivo de configuracion
require_once "config.php";

function visualizarDatos($link, $tabla, ...$columnas)
{
    $sql = "SELECT * FROM $tabla";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr>";

            //coger el nombre de las columnas
            $sql = "SHOW COLUMNS FROM $tabla";
            $cols = mysqli_query($link, $sql);

            // Mostrar los nombres de las columnas
            while ($col = mysqli_fetch_array($cols)) {
                if (in_array($col[0], $columnas)) {
                    echo "<th>" . $col[0] . "</th>";
                }
            }
            echo "<th><a href='#'>+Peliculas</a></th>";
            echo "</tr>";

            while ($row = mysqli_fetch_array($result)) {
                $id = $row['id_pelicula']; // Cambiar id si es necesario
                echo "<tr>";
                foreach ($columnas as $col) {
                    if ($col == "caratula") { // Quitar condicion si no es necesaria
                        echo "<td><img src='" . $row[$col] . "' width='100px'></td>";
                    } else {
                        echo "<td>" . $row[$col] . "</td>";
                    }
                }
                echo "<td>";
                echo "<a href='update.php?id=" . $row[$id] . "'>Editar</a>";
                echo " | ";
                echo "<a href='delete.php?id=" . $row[$id] . "'>Eliminar</a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";

            mysqli_free_result($result);
        } else {
            echo "<span style='color:red;font-style: italic;'>No hay registros.<span>";
        }
    } else {
        echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($link);
    }
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Peliculas</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <div class="centrar">
        <header>
            <h1>Peliculas</h1>
        </header>
        <main>
            <?php
            visualizarDatos($link, "peliculas", "id_pelicula", "titulo", "caratula");
            mysqli_close($link);
            ?>
            <main>
    </div>
</body>

</html>