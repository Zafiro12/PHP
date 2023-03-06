<?php
if (isset($_POST["login"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {
        $lector = $_POST["usuario"];
        $clave = md5($_POST["clave"]);

        $url = URL_BASE . "/login";

        $datos = array(
            "lector" => $lector,
            "clave" => $clave
        );

        $respuesta = consumir_servicios_REST($url, "POST", $datos);

        $obj = json_decode($respuesta);

        if (!$obj) {
            die("<p>Error en la respuesta del servidor</p>");
        }

        if (isset($obj->error)) {
            die("<p>Error: " . $obj->error . "</p>");
        }

        if (isset($obj->mensaje)) {
            $error_usuario = true;
        } else {
            $_SESSION["tipo"] = $obj->usuario->tipo;
            $_SESSION["usuario"] = $lector;
            $_SESSION["clave"] = $clave;
            $_SESSION["key"]["api_session"] = $obj->api_session;
            $_SESSION["ultimo_acceso"] = time();

            header("Location: index.php");
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
    <title>Login</title>
    <style>
        .libros {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .libro {
            border: 1px solid black;
            margin: 10px;
            padding: 10px;
            text-align: center;

            flex: 25%;
        }

        .libro>img {
            width: 75%;
        }
    </style>
</head>

<body>
    <h1>Libreria</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?php
                                                                    if (isset($_POST["usuario"])) {
                                                                        echo $_POST["usuario"];
                                                                    }
                                                                    ?>">
            <?php
            if (isset($error_usuario) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span style='color:red'>* El usuario no puede estar vacío</span>";
                }else{
                    echo "<span style='color:red'>* El usuario es incorrecto o no existe</span>";
                }
            }
            ?>
        </p>

        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave">
        </p>

        <input type="submit" name="login" value="Entrar">
    </form>

    <h2>Listado de los libros</h2>
    <?php
    $url = URL_BASE . "/obtenerLibros";

    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);

    if (!$obj) {
        die("<p>Error en la respuesta del servidor</p>");
    }

    if (isset($obj->error)) {
        die("<p>Error: " . $obj->error . "</p>");
    }
    echo "<div class='libros'>";
    foreach ($obj->libros as $libro) {
        echo "<div class='libro'>";
        echo "<img src='images/" . $libro->portada . "' alt='Portada del libro'>";
        echo "<p><strong>" . $libro->titulo . "</strong> - " . $libro->precio . "</p>";
        echo "</div>";
    }
    echo "</div>";
    ?>
</body>

</html>