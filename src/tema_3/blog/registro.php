<?php
// TODO El id de los usuarios aumenta incluso si no se crea el usuario

require_once "admin/config.php";

if (isset($_POST["salir"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["registro"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_nombre = $_POST["nombre"] == "";
    $error_email = $_POST["email"] == "";
    $error_form = $error_clave || $error_usuario || $error_nombre || $error_email;

    if (!$error_form) {
        $datos["usuario"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["clave"]);
        $datos["nombre"] = $_POST["nombre"];
        $datos["email"] = $_POST["email"];

        $consulta = "SELECT * FROM usuarios WHERE usuario = ?";
        $array = [$datos["usuario"]];
        $sentencia = ejecutar_consulta($consulta, $array);

        $error_usuario = $sentencia->rowCount() > 0;

        $consulta = "SELECT * FROM usuarios WHERE email = ?";
        $array = [$datos["email"]];
        $sentencia = ejecutar_consulta($consulta, $array);

        $error_email = $sentencia->rowCount() > 0;
        $error_repeticion = $error_email || $error_usuario;

        if (!$error_repeticion) {
            $consulta = "INSERT INTO usuarios (usuario, password, nombre, email) VALUES (?, ?, ?, ?)";
            $array = [$datos["usuario"], $datos["clave"], $datos["nombre"], $datos["email"]];
            $sentencia = ejecutar_consulta($consulta, $array);

            if ($sentencia) {
                $_SESSION["usuario"] = $datos["usuario"] ;
                $_SESSION["clave"] = $datos["clave"];
                $_SESSION["ultimo_acceso"] = time();
                header("Location: index.php");
                exit();
            } else {
                $error_usuario = true;
            }
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro</title>
</head>
<body>
<h1>Registro</h1>
<form action="registro.php" method="post">
    <p>
        <label for="usuario">Nombre de usuario</label>
        <input type="text" name="usuario" id="usuario"
               value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
        <?php
        if (isset($_POST["usuario"]) && isset($error_usuario)) {
            if ($error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span style='color: red;'>*Campo vacío</span>";
                } else {
                    echo "<span style='color: red;'>*El usuario ya existe</span>";
                }
            }
        }
        ?>
    </p>
    <p>
        <label for="clave">Contraseña</label>
        <input type="password" name="clave" id="clave">
        <?php
        if (isset($_POST["clave"]) && isset($error_clave)) {
            if ($error_clave) {
                echo "<span style='color: red;'>*Campo vacío</span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre"
               value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>">
        <?php
        if (isset($_POST["nombre"]) && isset($error_nombre)) {
            if ($error_nombre) {
                echo "<span style='color: red;'>*Campo vacío</span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php if (isset($_POST["email"])) echo $_POST["email"]; ?>">
        <?php
        if (isset($_POST["email"]) && isset($error_email)) {
            if ($error_email) {
                if ($_POST["email"] == "") {
                    echo "<span style='color: red;'>*Campo vacío</span>";
                } else {
                    echo "<span style='color: red;'>*El email ya existe</span>";
                }
            }
        }
        ?>
    </p>
    <input type="submit" name="registro" value="Registrarse">
    <input type="submit" name="salir" value="Salir">
</form>
</body>
</html>