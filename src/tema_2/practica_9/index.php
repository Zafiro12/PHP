<?php
function visualizarDatos($link, $tabla)
{
    $enlaces = array(
        "https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/Red_X.svg/1024px-Red_X.svg.png",
        "https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/Edit_icon_%28the_Noun_Project_30184%29.svg/1024px-Edit_icon_%28the_Noun_Project_30184%29.svg.png",
        "https://www.freeiconspng.com/thumbs/eye-icon/eyeball-icon-png-eye-icon-1.png"
    );

    $sql = "SELECT * FROM $tabla";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr>";
            $nameArray = array();
            while ($fieldinfo = mysqli_fetch_field($result)) {
                if ($fieldinfo->name == "id_pelicula" || $fieldinfo->name == "titulo" || $fieldinfo->name == "caratula") {
                    echo "<th>" . $fieldinfo->name . "</th>";
                    array_push($nameArray, $fieldinfo->name);
                }
                
            }
            echo "<th>Acciones</th>";
            echo "</tr>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                foreach ($nameArray as $name) {
                    if ($name == "caratula") {
                        echo "<td><img src='" . $row[$name] . "' width='100px'></td>";
                    } else {
                        echo "<td>" . $row[$name] . "</td>";
                    }
                }
                echo "<td>";
                echo "<a href='delete.php?id=" . $row['id_pelicula'] . "'><img src='" . $enlaces[0] . "' width='20px' height='20px'></a>" . PHP_EOL;
                echo "<a href='update.php?id=" . $row['id_pelicula'] . "'><img src='" . $enlaces[1] . "' width='20px' height='20px'></a>" . PHP_EOL;
                echo "<a href='view.php?id=" . $row['id_pelicula'] . "'><img src='" . $enlaces[2] . "' width='20px' height='20px'></a>" . PHP_EOL;
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
            <button type="button" onclick="window.location.href='create.php'">Insertar pelicula</button>
        </header>
        <main>
            <?php
            // Incluir archivo de configuracion
            require_once "config.php";
            visualizarDatos($link, "peliculas");
            // Cerrar conexion
            mysqli_close($link);
            ?>
            <main>
    </div>
</body>

</html>