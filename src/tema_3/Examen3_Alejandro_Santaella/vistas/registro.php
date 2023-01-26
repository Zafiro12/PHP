<?php
if (isset($_POST["salir"])) {
    unset($_POST["registrarse"]);
    header("Location: funciones.php");
    exit();
}

if (isset($_POST["registro"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_repeticion = false;

    if (!$error_clave && $_POST["clave"] != $_POST["repetir"]) {
        $error_repeticion = true;
    }

    $error_imagen = false;

    $error_form = $error_usuario || $error_clave || $error_repeticion;

    if (!$error_form) {
        $consulta = "select * from clientes where usuario = ?";
        $resultado = ejecutar_consulta($consulta, array($_POST["usuario"]))->fetch(PDO::FETCH_ASSOC);

        if (!$resultado) {
            $imagen = "no_imagen.jpg";

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
                        $imagen = $nombre;
                    } else {
                        $error_imagen = true;
                    }
                } else {
                    $error_imagen = true;
                }
            }

            if (!$error_imagen) {
                $consulta = "insert into clientes (usuario, clave, foto) values (?, ?, ?)";
                $array = array($_POST["usuario"], md5($_POST["clave"]), $imagen);
                ejecutar_consulta($consulta, $array);
                $_SESSION["usuario"] = $_POST["usuario"];
                $_SESSION["clave"] = md5($_POST["clave"]);
                $_SESSION["ultimo_acceso"] = time();
                header("Location: funciones.php");
                exit();
            }
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
<form action="index.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="registrarse">
    <p>
        <label for="usuario">Nombre de usuario:</label>
        <input type="text" id="usuario" name="usuario"
               value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
        <?php
        if (isset($_POST["registro"])) {
            if ($error_usuario && $_POST["usuario"] == "") {
                echo "<span style='color: red'>*Campo vacío</span>";
            } else if ($error_usuario) {
                echo "<span style='color: red'>*El usuario ya existe</span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="clave">Contraseña:</label>
        <input type="password" id="clave" name="clave">
        <?php
        if (isset($_POST["registro"])) {
            if ($_POST["clave"] == "") {
                echo "<span style='color: red'>*Campo vacío</span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="repetir">Repite la contraseña:</label>
        <input type="password" id="repetir" name="repetir">
        <?php
        if (isset($_POST["registro"])) {
            if ($error_repeticion) {
                echo "<span style='color: red'>*Las contraseñas no coinciden</span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="imagen">Imagen de perfil:</label>
        <input type="file" id="imagen" name="imagen">
        <?php
        if (isset($_POST["registro"])) {
            if ($error_imagen) {
                echo "<span style='color: red'>*La imagen no es válida</span>";
            }
        }
        ?>
    </p>
    <input type="submit" name="salir" value="Salir">
    <input type="submit" name="registro" value="Registrarse">
</body>
</html>