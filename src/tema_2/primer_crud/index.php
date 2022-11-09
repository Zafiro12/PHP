<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Crud</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
            padding: 5px;
            margin: 10px;
        }
        td {
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Listado de los usuarios:</h1>
    <table>
        <tr><th>Nombre</th><th>Borrar</th><th>Editar</th></tr>
        <?php
        $enlaces = array(
            "https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/Red_X.svg/1024px-Red_X.svg.png",
            "https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/Edit_icon_%28the_Noun_Project_30184%29.svg/1024px-Edit_icon_%28the_Noun_Project_30184%29.svg.png"
        );

        @$conexion = mysqli_connect("db", "jose", "josefa", "bd_foro");
        if (!$conexion) {
            die("Imposible conectar. Error número " . mysqli_connect_errno() . ": " . mysqli_connect_error());
        }
        $consulta = "SELECT * FROM usuarios";
        $resultado = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($resultado)) {
            echo "<tr><td>" . $fila['nombre'] . "</td><td><img src='". $enlaces[0] ."' height='10px'></td><td><img src='". $enlaces[1] ."' height='20px'></td></tr>";
        }
        ?>
    </table>

    <form action="usuario_nuevo.php" method="post">
        <input type="submit" name="submit" value="Introducir un nuevo usuario">
    </form>
</body>

</html>