<?php
$conexion = mysqli_connect("db", "jose", "josefa", "bd_foro") or die("<p>Imposible conectar. Error número " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p>");

$error_nombre = false;
$error_usuario = false;
$error_clave = false;
$error_email = false;

if (isset($_POST['continuar'])) {
    $error_nombre = empty($_POST['nombre']);
    $error_clave = empty($_POST['clave']);
    $error_email = empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    $consulta = "SELECT * FROM usuarios WHERE usuario = '" . $_POST['usuario'] . "'";
    $resultado = mysqli_query($conexion, $consulta) or die("<p>Imposible ejecutar la consulta. Error número " . mysqli_errno($conexion) . ": " . mysqli_error($conexion) . "</p>");

    $error_usuario = mysqli_num_rows($resultado) > 0 || empty($_POST['usuario']);

    if (!$error_nombre && !$error_clave && !$error_email && !$error_usuario) {

        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $clave = md5($_POST['clave']);
        $email = $_POST['email'];

        $consulta = "INSERT INTO usuarios (nombre, usuario, clave, email) VALUES ('$nombre', '$usuario', '$clave', '$email')";
        $resultado = mysqli_query($conexion, $consulta);
        if ($resultado) {
            mysqli_close($conexion);
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
<html lang="es">

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
        <input type="text" name="nombre" id="nombre"> 
        <?php if ($error_nombre) echo "<span style='color:red'>El nombre no puede estar vacío</span>"; ?>
        <br><br>

        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" id="usuario"> 
        <?php if ($error_usuario) echo "<span style='color:red'>El usuario no puede estar vacío o ya existe</span>"; ?>
        <br><br>

        <label for="clave">Clave</label>
        <input type="password" name="clave" id="clave" minlength="8"> 
        <?php if ($error_clave) echo "<span style='color:red'>La clave no puede estar vacía</span>"; ?>
        <br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email"> 
        <?php if ($error_email) echo "<span style='color:red'>El email no puede estar vacío o no es válido</span>"; ?>
        <br><br>
        
        <input type="submit" name="continuar" value="Continuar">
        <input type="submit" name="volver" value="Volver">
    </form>
</body>

</html>