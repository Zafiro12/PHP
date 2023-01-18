<?php
if (isset($_POST["login"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_clave || $error_usuario;

    if (!$error_form) {
        $consulta = "SELECT * FROM usuarios WHERE usuario = ? AND password = ?";

        $datos[] = $_POST["usuario"];
        $datos[] = md5($_POST["clave"]);

        $sentencia = ejecutar_consulta($consulta, $datos);

        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
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
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
</head>

<body>
<h1>Blog personal</h1>
<form action="index.php" method="post">
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
                    echo "<span style='color: red;'>*El usuario no es correcto</span>";
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
    <input type="submit" name="login" value="Entrar">
    <input type="submit" formaction="registro.php" value="Registrarse">
</form>
</body>

</html>
