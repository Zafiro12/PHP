<?php
function visualizarDatos($link, $tabla, ...$columnas)
{
    $sql = "SELECT * FROM $tabla WHERE administrador = 0"; // !Cambiar sql si es necesario
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr>";

            // *Coger el titulo de las columnas
            $sql = "SHOW COLUMNS FROM $tabla";
            $cols = mysqli_query($link, $sql);

            // *Mostrar los titulos de las columnas
            while ($col = mysqli_fetch_array($cols)) {
                if (in_array($col[0], $columnas)) {
                    echo "<th>" . $col[0] . "</th>";
                }
            }

            mysqli_free_result($cols);

            echo "<th><a href='index.php?crear=1'>+Añadir</a></th>";
            echo "</tr>";

            while ($row = mysqli_fetch_array($result)) {
                $id = $row['id_usuario']; // !Cambiar id si es necesario
                echo "<tr>";
                foreach ($columnas as $col) {
                    if ($col == "usuario") { // !Cambiar columna de vista si es necesario
                        echo "<td><a href='index.php?id=$id&ver=1'>" . $row[$col] . "</a></td>";
                    } else {
                        echo "<td>" . $row[$col] . "</td>";
                    }
                }
                echo "<td>";
                echo "<a href='index.php?id=$id&editar=1'>Editar</a>";
                echo " || ";
                echo "<a href='index.php?id=$id&borrar=1'>Borrar</a>";
                echo "</td>";
                echo "</tr>";
            }

            mysqli_free_result($result);

            echo "</table>";
        } else {
            echo "<span style='color:red;font-style: italic;'>No hay registros.<span><br><a href='create.php'>Añadir</a>";
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
    <title>Usuarios</title>
</head>

<body>
    <header>
        <h1>Usuarios</h1>
    </header>
    <main>
        <?php
        visualizarDatos($link, "usuarios", "usuario", "email");
        echo "<a href='index.php?salir=1'>Cerrar sesión</a>";
        ?>
        <main>
</body>

</html>