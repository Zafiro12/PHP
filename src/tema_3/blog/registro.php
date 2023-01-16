<?php
    if (isset($_POST["registro"])) {
        $error_usuario = $_POST["usuario"] == "";
        $error_clave = $_POST["clave"] == "";
        $error_nombre = $_POST["nombre"] == "";
        $error_email = $_POST["email"] == "";
        $error_form = $error_clave || $error_usuario || $error_nombre || $error_email;

        if (!$error_form) {
            $conexion = new Conexion(HOST, DB, USER, PASSWORD);
            $usuarios = new Usuarios($conexion->conectar());

            $datos[] = $_POST["usuario"];
            $datos[] = md5($_POST["clave"]);
            $datos[] = $_POST["nombre"];
            $datos[] = $_POST["email"];

            $resultado = $usuarios->insertar($datos);

            if ($resultado!=0) {
                $_SESSION["usuario"] = $datos[0];
                $_SESSION["clave"] = $datos[1];
                $_SESSION["ultimo_acceso"] = time();
                header("Location: index.php");
                exit();
            } else {
                $error_usuario = true;
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
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Nombre de usuario</label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
            <?php
            if (isset($_POST["usuario"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span style='color: red;'>*Campo vacío</span>";
                } else {
                    echo "<span style='color: red;'>*El usuario no es correcto</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña</label>
            <input type="password" name="clave" id="clave">
            <?php
            if (isset($_POST["clave"]) && $error_clave) {
                echo "<span style='color: red;'>*Campo vacío</span>";
            }
            ?>
        </p>
        <p>
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>">
            <?php
            if (isset($_POST["nombre"]) && $error_nombre) {
                if ($_POST["nombre"] == "") {
                    echo "<span style='color: red;'>*Campo vacío</span>";
                } else {
                    echo "<span style='color: red;'>*El usuario no es correcto</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php if (isset($_POST["email"])) echo $_POST["email"]; ?>">
            <?php
            if (isset($_POST["email"]) && $error_email) {
                if ($_POST["email"] == "") {
                    echo "<span style='color: red;'>*Campo vacío</span>";
                } else {
                    echo "<span style='color: red;'>*El usuario no es correcto</span>";
                }
            }
            ?>
        </p>
        <input type="submit" name="registro" value="Registrarse">
        <input type="submit" name="salir" value="Salir">
    </form>
</body>
</html>