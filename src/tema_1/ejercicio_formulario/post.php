<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejemplo de Formulario</title>
</head>

<body>

<?php
function letraNIF($dni): string
{
    return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
}

$error_nombre = empty($_POST['nombre']) || strlen($_POST['nombre']) > 20;
$error_usuario = empty($_POST['usuario']);
$error_pwd = empty($_POST['pwd']) || strlen($_POST['pwd']) > 8;
$error_nif = empty($_POST['nif']) || strlen($_POST['nif']) != 9 || letraNIF($_POST['nif']) != strtoupper(substr($_POST['nif'], -1)) ;
$error_sexo = !isset($_POST['sexo']);
$foto = $_FILES['foto'];

if (isset($_POST['enviar']) && !$error_nombre && !$error_usuario && !$error_pwd && !$error_nif && !$error_sexo) {
    echo "<h2>Datos recibidos:</h2>";
    echo "Nombre: " . $_POST['nombre'] . "<br>";
    echo "Usuario: " . $_POST['usuario'] . "<br>";
    echo "Contraseña: " . $_POST['pwd'] . "<br>";
    echo "NIF: " . $_POST['nif'] . "<br>";
    echo "Sexo: " . $_POST['sexo'] . "<br>";
    echo "Suscripción: " . (isset($_POST['sub']) ? "Sí" : "No") . "<br>";
    if ($_FILES['foto']['name'] != "") {
        /* Si se selecciona una imagen correctamente, esta será movida y renombrada con un nombre
         * nuevo y único y con la misma extensión, a una carpeta dentro de la web llamada “images”.*/
        $nombre_unico = md5(uniqid(uniqid(),true));
        $error_foto = $_FILES['foto']['error'] != 0 || $_FILES['foto']['size'] > 500000;
        $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        if (!$error_foto && in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            move_uploaded_file($_FILES['foto']['tmp_name'], "images/$nombre_unico.$extension");
            echo "<h2>Información de la imagen seleccionada</h2>";
            echo "Foto: <img src='images/$nombre_unico.$extension' alt='Foto de perfil' width='100px'><br>";
            echo "Nombre: " . $_FILES['foto']['name'] . "<br>";
            echo "Tipo: " . $_FILES['foto']['type'] . "<br>";
            echo "Tamaño: " . $_FILES['foto']['size'] . "<br>";
            echo "Ruta en el servidor: images/$nombre_unico.$extension<br>";
        } else {
            echo "Foto: No se ha podido subir la foto<br>";
        }
    } else {
        echo "No se ha seleccionado ninguna foto";
    }
} else {
    ?>

    <header>
        <h1>Rellena tu CV</h1>
    </header>
    <main>
        <form action="post.php" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre:<br></label>
            <input type="text" name="nombre" id="nombre" value="<?php
            if (isset($_POST['enviar'])) {
                echo $_POST['nombre'];
            }
            ?>"> <?php
            if ($error_nombre) {
                echo "<span style='color: red'>Nombre incorrecto</span>";
            }
            ?>
            <br><br>

            <label for="usuario">Usuario:<br></label>
            <input type="text" name="usuario" id="usuario" value="<?php
            if (isset($_POST['enviar'])) {
                echo $_POST['usuario'];
            }
            ?>"> <?php
            if ($error_usuario) {
                echo "<span style='color: red'>Usuario incorrecto</span>";
            }
            ?>
            <br><br>

            <label for="pwd">Contraseña:<br></label>
            <input type="password" name="pwd" id="pwd"> <?php
            if ($error_pwd) {
                echo "<span style='color: red'>Contraseña incorrecta</span>";
            }
            ?>
            <br><br>

            <label for="nif">DNI<br></label>
            <input type="text" name="nif" id="nif" value="<?php
            if (isset($_POST['enviar'])) {
                echo $_POST['nif'];
            }
            ?>"> <?php
            if ($error_nif) {
                echo "<span style='color: red'>NIF incorrecto</span>";
            }
            ?>
            <br><br>

            <fieldset>
                <legend>Sexo</legend>
                <?php
                if ($error_sexo) {
                    echo "<span style='color: red'>Obligatorio</span><br>";
                }
                ?>
                <input type="radio" name="sexo" id="hombre" value="hombre">
                <label for="hombre">Hombre</label>
                <br>
                <input type="radio" name="sexo" id="mujer" value="mujer">
                <label for="mujer">Mujer</label>
            </fieldset>
            <br><br>

            <label for="foto">Incluir mi foto (Archivo tipo imagen máx. 500kb):</label>
            <input type="file" name="foto" id="foto">
            <br><br>

            <input type="checkbox" name="sub" id="sub" checked>
            <label for="sub">Subscribirse al boletín de Novedades</label>
            <br><br>

            <input type="submit" name="enviar" value="Guardar cambios">
            <input type="reset" value="Borrar los datos introducidos">
        </form>
    </main>
    <?php
}
?>
</body>
</html>