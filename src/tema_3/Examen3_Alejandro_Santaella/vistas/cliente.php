<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Examen3</title>
</head>
<body>
<h1>Video club</h1>
<?php
echo "<h2>Bienvenido " . $_SESSION["usuario"] . " - <a href='funciones.php?salir=1'>Salir</a></h2>";

$consulta = "select * from clientes where usuario = ? and clave = ?";
$resultado = ejecutar_consulta($consulta, array($_SESSION["usuario"], $_SESSION["clave"]))->fetch(PDO::FETCH_ASSOC);

if (isset($_POST["eliminar"])) {
    if ($resultado["foto"] != "no_imagen.jpg") {
        unlink("Images/" . $resultado["foto"]);
    }

    $consulta = "UPDATE clientes SET foto = 'no_imagen.jpg' WHERE usuario = ? and clave = ?";
    ejecutar_consulta($consulta, array($_SESSION["usuario"], $_SESSION["clave"]));
}

if (isset($_POST["cambiar"])) {
    $imagen = $resultado["foto"];
    $error_imagen = false;

    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["name"] != "") {
        if ($_FILES["imagen"]["error"] == 0 && $_FILES["imagen"]["size"] < 500000) {
            $tipo = $_FILES["imagen"]["type"];

            if ($tipo == "image/jpeg" || $tipo == "image/png") {
                try {
                    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                } catch (PDOException $e) {
                    pagina_error($e->getMessage());
                }

                //$id = $conexion->lastInsertId();
                $id = time();

                $nombre = $_FILES["imagen"]["name"];
                $nombre = explode(".", $nombre);
                $nombre = "img" . $id . "." . $nombre[1];

                move_uploaded_file($_FILES["imagen"]["tmp_name"], "Images/" . $nombre);
                if ($resultado["foto"] != "no_imagen.jpg") {
                    unlink("Images/" . $resultado["foto"]);
                }
                $imagen = $nombre;
            } else {
                $error_imagen = true;
            }
        } else {
            $error_imagen = true;
        }
    }

    if (!$error_imagen) {
        $consulta = "UPDATE clientes SET foto = '".$imagen."' WHERE usuario = ? and clave = ?";
        ejecutar_consulta($consulta, array($_SESSION["usuario"], $_SESSION["clave"]));
    }
}

$consulta = "select * from clientes where usuario = ? and clave = ?";
$resultado = ejecutar_consulta($consulta, array($_SESSION["usuario"], $_SESSION["clave"]))->fetch(PDO::FETCH_ASSOC);

echo "<form action='funciones.php' method='post' enctype='multipart/form-data'>";

echo "<h3>Foto de perfil:</h3>";
echo "<img src='Images/" . $resultado["foto"] . "' alt='foto' height='100px'>";
echo "<p><input type='submit' name='eliminar' value='Eliminar foto'></p>";
echo "<p><input type='file' name='imagen'>";
if (isset($error_imagen) && $error_imagen) {
    echo "<span style='color: red'>Error al subir la imagen</span>";
}
echo "</p>";
echo "<p><input type='submit' name='cambiar' value='Cambiar foto'></p>";
echo "</form>";
?>
</body>
</html>