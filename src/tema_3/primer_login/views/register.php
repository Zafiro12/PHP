<?php
require_once "assets/config.php";

$error_nombre = false;
$error_usuario = false;
$error_clave = false;
$error_email = false;

$error_registro = false;

if (isset($_POST['registrarse'])) {
    // *** NOMBRE Y CLAVE ***
    $error_nombre = empty($_POST['nombre']);
    $error_clave = empty($_POST['clave']);

    // *** EMAIL ***
    $sql = "SELECT * FROM usuarios WHERE email = '" . $_POST['email'] . "'";
    $result = mysqli_query($link, $sql) or die("<p>Imposible ejecutar la consulta. Error número " . mysqli_errno($link) . ": " . mysqli_error($link) . "</p><a href='index.php?salir=true'>Volver</a>");
    $error_email = empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || mysqli_num_rows($result) > 0;

    // *** USUARIO ***
    $sql = "SELECT * FROM usuarios WHERE usuario = '" . $_POST['usuario'] . "'";
    $result = mysqli_query($link, $sql) or die("<p>Imposible ejecutar la consulta. Error número " . mysqli_errno($link) . ": " . mysqli_error($link) . "</p><a href='index.php?salir=true'>Volver</a>");
    $error_usuario = mysqli_num_rows($result) > 0 || empty($_POST['usuario']);

    $error_registro = $error_nombre || $error_clave || $error_email || $error_usuario;

    if (!$error_registro) {
        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $clave = md5($_POST['clave']);
        $email = $_POST['email'];

        $sql = "INSERT INTO usuarios (nombre, usuario, clave, email) VALUES ('$nombre', '$usuario', '$clave', '$email')";
        $result = mysqli_query($link, $sql);
        if ($result) {
            mysqli_close($link);
            $_SESSION['email'] = $email;
            header("Location: index.php");
        } else {
            echo "Error al insertar el usuario";
            echo "<a href='index.php?salir=true'>Volver</a>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;

            height: 50vh;

            padding: 1rem;
            margin: 1rem;
        }

        .input {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <form action="index.php" method="post">
        <h2>Registro</h2>

        <div class="input">
            <?php if ($error_nombre) echo "<span style='color:red'>El nombre no puede estar vacío</span>"; ?>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre">
        </div>

        <div class="input">
            <?php if ($error_usuario) echo "<span style='color:red'>El usuario no puede estar vacío o ya existe</span>"; ?>
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario">
        </div>

        <div class="input">
            <?php if ($error_clave) echo "<span style='color:red'>La clave no puede estar vacía</span>"; ?>
            <label for="clave">Clave</label>
            <input type="password" name="clave" id="clave" minlength="8">
        </div>

        <div class="input">
            <?php if ($error_email) echo "<span style='color:red'>El email no puede estar vacío o no es válido</span>"; ?>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email">
        </div>

        <div>
            <input type="submit" name="registrarse" value="Registrarse">
            <input type="submit" formaction="index.php?salir=true" value="Volver">
        </div>
    </form>
</body>

</html>