<?php
$conexion = mysqli_connect("db", "jose", "josefa", "bd_foro") or die("<p>Imposible conectar. Error número " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p>");
$enlaces = array(
    "https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/Red_X.svg/1024px-Red_X.svg.png",
    "https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/Edit_icon_%28the_Noun_Project_30184%29.svg/1024px-Edit_icon_%28the_Noun_Project_30184%29.svg.png"
);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Crud</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
            padding: 5px;
            margin: 10px;
        }
    </style>
</head>

<body>
    <h1>Listado de los usuarios:</h1>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Borrar</th>
            <th>Editar</th>
        </tr>
        <?php
        $consulta = "SELECT * FROM usuarios";

        $resultado = mysqli_query($conexion, $consulta);

        while ($fila = mysqli_fetch_array($resultado)) {
            echo "<tr><td><a href='#'>" . $fila['nombre'] . "</a></td>
            <td><a href='#'><img src='" . $enlaces[0] . "' height='10px'></a></td>
            <td><a href='#'><img src='" . $enlaces[1] . "' height='20px'></a></td></tr>";
        }
        ?>
    </table>

    <form action="usuario_nuevo.php" method="post">
        <input type="submit" name="submit" value="Introducir un nuevo usuario">
    </form>

    <?php
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
</body>

</html>