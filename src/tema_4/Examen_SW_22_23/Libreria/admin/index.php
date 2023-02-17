<?php
if (isset($_GET["br"])) {
    $_SESSION["br"] = $_GET["br"];
    header("Location: index.php");
}

if (isset($_GET["ed"])) {
    $_SESSION["ed"] = $_GET["ed"];
    header("Location: index.php");
}

if (isset($_POST["add"])) {
    $error_referencia = $_POST["referencia"] == "" || !is_numeric($_POST["referencia"]);
    $error_titulo = $_POST["titulo"] == "";
    $error_autor = $_POST["autor"] == "";
    $error_descripcion = $_POST["descripcion"] == "";
    $error_precio = $_POST["precio"] == "" || !is_numeric($_POST["precio"]);
    $error_form = $error_referencia || $error_titulo || $error_autor || $error_descripcion || $error_precio;

    if (!$error_form) {
        $url = DIR . "/obtenerLibros";
        $respuesta = json_decode(consumir_servicios_REST($url, "GET"), true);
        if (isset($respuesta["error"])) {
            echo error_page("Error", "Error al obtener los libros", $respuesta["error"]);
        } else {
            $libros = $respuesta["libros"];
            $existe = false;
            foreach ($libros as $libro) {
                if ($libro["referencia"] == $_POST["referencia"]) {
                    $existe = true;
                    break;
                }
            }
            if (!$existe) {
                $url = DIR . "/crearLibro";
                $respuesta = json_decode(consumir_servicios_REST($url, "POST", array(
                    "referencia" => $_POST["referencia"],
                    "titulo" => $_POST["titulo"],
                    "autor" => $_POST["autor"],
                    "descripcion" => $_POST["descripcion"],
                    "precio" => $_POST["precio"],
                    "api_session" => $_SESSION["api_session"]
                )), true);
                if (isset($respuesta["error"])) {
                    echo error_page("Error", "Error al insertar el libro", $respuesta["error"]);
                } else {
                    if (isset($respuesta["mensaje"])) {
                        $error_portada = $_FILES["portada"]["error"] != 0 || $_FILES["portada"]["type"] != "image/jpeg" || $_FILES["portada"]["size"] > 500000;
                        if (!$error_portada) {
                            $url = DIR . "/actualizarPortada";
                            $respuesta = json_decode(consumir_servicios_REST($url, "POST", array(
                                "referencia" => $_POST["referencia"],
                                "portada" => "img_" . $_POST["referencia"] . ".jpg",
                                "api_session" => $_SESSION["api_session"]
                            )), true);
                            if (isset($respuesta["error"])) {
                                echo error_page("Error", "Error al actualizar la portada", $respuesta["error"]);
                            } else {
                                if (isset($respuesta["mensaje"])) {
                                    move_uploaded_file($_FILES["portada"]["tmp_name"], "../images/img_" . $_POST["referencia"] . ".jpg");
                                    header("Location: index.php");
                                } else {
                                    echo error_page("Error", "Error al actualizar la portada", "No se ha podido insertar el libro");
                                }
                            }
                        }
                    } else {
                        echo error_page("Error", "Error al insertar el libro", "No se ha podido insertar el libro");
                    }
                }
            } else {
                echo error_page("Error", "Error al insertar el libro", "Ya existe un libro con esa referencia");
            }
        }
    }
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vista Admin</title>
</head>
<body>
<h1>Librería</h1>
<h2>Bienvenido <?php echo $_SESSION["usuario"] ?></h2>
<form action="index.php" method="post">
    <input type="submit" name="logout" value="Salir">
</form>
<?php
echo "<h2>Listado de los libros</h2>";
echo "<table border='1'>";
echo "<tr><th>Ref</th><th>Titulo</th><th>Accion</th></tr>";

$url = DIR . "/obtenerLibros";
$respuesta = json_decode(consumir_servicios_REST($url, "GET"), true);
if (isset($respuesta["error"])) {
    echo error_page("Error", "Error al obtener los libros", $respuesta["error"]);
} else {
    foreach ($respuesta["libros"] as $libro) {
        echo "<tr>";
        echo "<td>" . $libro["referencia"] . "</td>";
        echo "<td>" . $libro["titulo"] . "</td>";
        echo "<td><a href='index.php?br=" . $libro["referencia"] . "'>Borrar</a> - <a href='index.php?ed=" . $libro["referencia"] . "'>Editar</a></td>";
        echo "</tr>";
    }
    echo "</table>";

    if (isset($_SESSION["br"])) {
        echo "El libro con referencia " . $_SESSION["br"] . " ha sido borrado";
        unset($_SESSION["br"]);
    }
    if (isset($_SESSION["ed"])) {
        echo "El libro con referencia " . $_SESSION["ed"] . " ha sido editado";
        unset($_SESSION["ed"]);
    }
}
?>
<h2>Añadir un libro</h2>
<form action="index.php" method="post" enctype="multipart/form-data">
    <p>
        <label for="referencia">Referencia:</label>
        <input type="text" name="referencia" id="referencia">
    </p>
    <p>
        <label for="titulo">Titulo:</label>
        <input type="text" name="titulo" id="titulo">
    </p>
    <p>
        <label for="autor">Autor:</label>
        <input type="text" name="autor" id="autor">
    </p>
    <p>
        <label for="descripcion">Descripcion:</label>
        <textarea name="descripcion" id="descripcion" cols="30" rows="10"></textarea>
    </p>
    <p>
        <label for="precio">Precio:</label>
        <input type="text" name="precio" id="precio">
    </p>
    <p>
        <label for="portada">Portada:</label>
        <input type="file" name="portada" id="portada">
    </p>
    <input type="submit" name="add" value="Añadir">
</form>
</body>
</html>
