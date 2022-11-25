<?php
function visualizarDatos($link, $tabla, ...$columnas)
{
    $sql = "SELECT * FROM $tabla";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr>";

            //coger el titulo de las columnas
            $sql = "SHOW COLUMNS FROM $tabla";
            $cols = mysqli_query($link, $sql);

            // Mostrar los titulos de las columnas
            while ($col = mysqli_fetch_array($cols)) {
                if (in_array($col[0], $columnas)) {
                    echo "<th>" . $col[0] . "</th>";
                }
            }

            mysqli_free_result($cols);

            echo "<th><a href='create.php'>+Pelicula</a></th>";
            echo "</tr>";

            while ($row = mysqli_fetch_array($result)) {
                $id = $row['id_pelicula']; // Cambiar id si es necesario
                echo "<tr>";
                foreach ($columnas as $col) {
                    if ($col == "titulo") {
                        echo "<td><a href='view.php?id=$id'>" . $row[$col] . "</a></td>";
                    } else if ($col == "caratula") { // Quitar condicion si no es necesaria
                        echo "<td><img src='" . $row[$col] . "' width='100vw' height='auto'></td>";
                    } else {
                        echo "<td>" . $row[$col] . "</td>";
                    }
                }
                echo "<td>";
                echo "<a href='update.php?id=$id'>Editar</a>";
                echo " || ";
                echo "<a href='delete.php?id=$id'>Borrar</a>";
                echo "</td>";
                echo "</tr>";
            }

            mysqli_free_result($result);

            echo "</table>";
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
            // Incluir archivo de configuracion
            require_once "sql/config.php";
            visualizarDatos($link, "peliculas", "id_pelicula", "titulo", "caratula");
            // Cerrar conexion
            mysqli_close($link);
            ?>
            <main>
    </div>
</body>

</html>