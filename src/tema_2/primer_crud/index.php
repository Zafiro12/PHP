<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Crud</title>
</head>

<body>
    <h1>Listado de los usuarios:</h1>
    <ul>
        <?php
        @$conexion = mysqli_connect("db", "jose", "josefa", "bd_foro");
        if (!$conexion) {
            die("Imposible conectar. Error n&uacute;mero " . mysqli_connect_errno() . ": " . mysqli_connect_error());
        }
        $consulta = "SELECT * FROM usuarios";
        $resultado = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($resultado)) {
            echo "<li>" . $fila['nombre'] . "</li>";
        }
        ?>
    </ul>
</body>

</html>