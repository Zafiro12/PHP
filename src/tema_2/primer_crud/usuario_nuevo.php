<?php
@$conexion = mysqli_connect("db", "jose", "josefa", "bd_foro");
if (!$conexion) {
    die("Imposible conectar. Error número " . mysqli_connect_errno() . ": " . mysqli_connect_error());
}

if (isset($_POST['continuar'])) {
    if (!empty($_POST['nombre']) || !empty($_POST['usuario']) || !empty($_POST['clave']) || !empty($_POST['email'] && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))) {

        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];
        $email = $_POST['email'];

        $consulta = "INSERT INTO usuarios (nombre, usuario, clave, email) VALUES ('$nombre', '$usuario', '$clave', '$email')";
        $resultado = mysqli_query($conexion, $consulta);
        if ($resultado) {
            header("Location: index.php");
        } else {
            echo "Error al insertar el usuario";
        }
    }
} else if (isset($_POST['volver'])) {
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo usuario</title>
</head>

<body>
    <h1>Nuevo usuario</h1>
    <form action="usuario_nuevo.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre"><br><br>
        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" id="usuario"><br><br>
        <label for="clave">Clave</label>
        <input type="password" name="clave" id="clave"><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email"><br><br>
        <input type="submit" name="continuar" value="Continuar">
        <input type="submit" name="volver" value="Volver">
    </form>
</body>

</html>