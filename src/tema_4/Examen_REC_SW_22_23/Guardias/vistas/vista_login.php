<?php
if (isset($_POST["login"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_password = $_POST["password"] == "";
    $error_form = $error_usuario || $error_password;

    if (!$error_form) {
        $url = URL_BASE . "/login";
        $datos["usuario"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["password"]);

        $respuesta = consumir_servicios_REST($url, "POST", $datos);
        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            error_page("ERROR", "Error al consumir los servicios", $respuesta);
            exit;
        }

        if (isset($obj->error)) {
            session_destroy();
            error_page("ERROR", "Error al acceder a la base de datos", $obj->error);
            exit;
        }

        if (isset($obj->mensaje)) {
            $error_usuario = true;
        } else {
            $_SESSION["usuario"] = $obj->usuario;
            $_SESSION["api_session"] = ["api_session" => $obj->api_session];
            $_SESSION["ultimo_acceso"] = time();

            header("Location: " . $salto);
            exit;
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
    <title>Gestion de Guardias</title>
</head>

<body>
    <h1>Gestion de Guardias</h1>
    <?php
    if (isset($_SESSION["seguridad"])) {
        echo "<p style='color:red'>" . $_SESSION["seguridad"] . "</p>";
        unset($_SESSION["seguridad"]);
    }
    ?>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Nombre de usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST['usuario'])) echo $_POST['usuario']; ?>">
            <?php
            if (isset($_POST['login'])) {
                if (isset($error_usuario) && $error_usuario) {
                    if (empty($_POST['usuario'])) {
                        echo "<span style='color:red'>El campo usuario no puede estar vacío</span>";
                    } else {
                        echo "<span style='color:red'>El usuario o la contraseña no es correcto</span>";
                    }
                }
            }
            ?>
        </p>
        <p>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password">
            <?php
            if (isset($_POST['login'])) {
                if (isset($error_password) && $error_password) {
                    echo "<span style='color:red'>El campo contraseña no puede estar vacío</span>";
                }
            }
            ?>
        </p>
        <p>
            <input type="submit" name="login" value="Entrar">
        </p>
    </form>
</body>

</html>