<?php
if (isset($_POST["login"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {
        $array[] = $_POST["usuario"];
        $array[] = md5($_POST["clave"]);

        $consulta = "select * from clientes where usuario=? and clave=?";
        $resultado = ejecutar_consulta($consulta, $array)->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $_SESSION["usuario"] = $array[0];
            $_SESSION["clave"] = $array[1];
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
    <title>Examen3</title>
</head>
<body>
<h1>Video club</h1>
<form action="index.php" method="post">
    <p>
        <label for="usuario">Nombre de usuario:</label>
        <input type="text" id="usuario" name="usuario"
               value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
        <?php
        if (isset($_POST["login"])) {
            if ($error_usuario && $_POST["usuario"] == "") {
                echo "<span style='color: red'>*Campo vacío</span>";
            } else if ($error_usuario) {
                echo "<span style='color: red'>*El usuario o la contraseña no son válidos</span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="clave">Contraseña:</label>
        <input type="password" id="clave" name="clave">
        <?php
        if (isset($_POST["login"])) {
            if ($_POST["clave"] == "") {
                echo "<span style='color: red'>*Campo vacío</span>";
            }
        }
        ?>
    </p>
    <input type="submit" name="login" value="Entrar">
    <input type="submit" name="registrarse" value="Registrarse">
</form>
</body>
</html>