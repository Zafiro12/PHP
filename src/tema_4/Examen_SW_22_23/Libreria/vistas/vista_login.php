<?php
if (isset($_POST["login"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {
        $url = DIR . "/login";
        $datos["lector"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["clave"]);

        $respuesta = json_decode(consumir_servicios_REST($url, "POST", $datos));
        if (isset($respuesta->usuario)) {
            $_SESSION["usuario"] = $respuesta->usuario->lector;
            $_SESSION["clave"] = $respuesta->usuario->clave;
            $_SESSION["api_session"] = $respuesta->api_session;
            $_SESSION["ultimo_acceso"] = time();
            header("Location: index.php");
            exit();
        } else {
            echo error_page("Error", "Error", "Usuario o contraseña incorrectos");
        }
    } else {
        echo error_page("Error", "Error", "Usuario o contraseña incorrectos");
    }
}

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página Inicio</title>
</head>
<body>
<h1>Librería</h1>
<form action="index.php" method="post">
    <p>
        <label for="usuario">Nombre de usuario</label>
        <input type="text" name="usuario" id="usuario" value="<?php
        if (isset($_POST["usuario"])) {
            echo $_POST["usuario"];
        }
        ?>">
    </p>
    <p>
        <label for="clave">Contraseña:</label>
        <input type="password" name="clave" id="clave">
    </p>
    <input type="submit" name="login" value="Entrar">
</form>
<h2>Listado de los libros</h2>
<div style="display: flex;flex-flow: row wrap; justify-content: flex-start; width: 100%;">
    <?php
    getLibros();
    ?>
</div>

</body>
</html>
