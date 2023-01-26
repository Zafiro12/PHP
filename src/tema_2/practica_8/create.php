<?php
function insertar($link, $tabla, ...$args)
{
    $sql = "SHOW COLUMNS FROM $tabla";
    $columnas = mysqli_query($link, $sql);
    $sql = "INSERT INTO $tabla (";
    //salta la primera columna que es el id
    $columnas->fetch_assoc();

    while ($columna = $columnas->fetch_assoc()) {
        $sql .= $columna['Field'] . ",";
    }

    $sql = substr($sql, 0, -1) . ") VALUES (";
    foreach ($args as $arg) {
        $sql .= "'$arg',";
    }
    $sql = substr($sql, 0, -1) . ")";

    if (mysqli_query($link, $sql)) {
        return true;
    } else {
        return false;
    }
}

function comprobarNombre($nombre)
{
    if (strlen($nombre) < 3 || strlen($nombre) > 20) {
        return false;
    }
    return true;
}

function comprobarUsuario($link, $usuario)
{
    if (strlen($usuario) < 3 || strlen($usuario) > 20) {
        return false;
    }
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            mysqli_free_result($result);
            return false;
        }
        mysqli_free_result($result);
        return true;
    }
    return false;
}

function comprobarClave($clave)
{
    if (strlen($clave) < 8) {
        return false;
    }
    return true;
}

function comprobarDNI($dni)
{
    function LetraNIF($dni)
    {
        $valor = (int) ($dni / 23);
        $valor *= 23;
        $valor = $dni - $valor;
        $letras = "TRWAGMYFPDXBNJZSQVHLCKEO";
        $letraNif = substr($letras, $valor, 1);
        return $letraNif;
    }

    if (strlen($dni) != 9) {
        return false;
    }

    $letra = strtoupper(substr($dni, -1));
    $numeros = substr($dni, 0, -1);

    if (!is_numeric($numeros)) {
        return false;
    }

    if (LetraNIF($numeros) != $letra) {
        return false;
    }

    return true;
}

function transaccionFoto($file, $uniqueID) {
    $nombre = $file['name'];
    $tmp_name = $file['tmp_name'];
    $error = $file['error'];
    $size = $file['size'];

    if ($error != 0) {
        return false;
    }

    if ($size > 1000000) {
        return false;
    }

    if (strlen($nombre) < 3 || strlen($nombre) > 20) {
        return false;
    }

    $extensiones = ['jpg', 'jpeg', 'png', 'gif'];
    $extension = pathinfo($nombre, PATHINFO_EXTENSION);
    if (!in_array($extension, $extensiones)) {
        return false;
    }

    $destino = "img/$uniqueID.$extension";
    if (!move_uploaded_file($tmp_name, $destino)) {
        return false;
    }

    return true;
}

require_once "config.php";

$error_nombre = $error_usuario = $error_clave = $error_dni = $error_foto = $error_insercion = false;
$nombre = $clave = $usuario = $dni = $sexo = $foto = "";

if (isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $clave = $_POST['clave'];
    $usuario = $_POST['usuario'];
    $dni = $_POST['dni'];
    $sexo = $_POST['sexo'];

    if (!comprobarNombre($nombre)) {
        $error_nombre = true;
    }
    if (!comprobarUsuario($link, $usuario)) {
        $error_usuario = true;
    }
    if (!comprobarClave($clave)) {
        $error_clave = true;
    }
    if (!comprobarDNI($dni)) {
        $error_dni = true;
    }
    if (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])) {
        $uniqueID = uniqid();
        if (!transaccionFoto($_FILES['foto'], $uniqueID)) {
            $error_foto = true;
        } else {
            $foto = "img/".$uniqueID.".".pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        }
    }

    if (!$error_nombre && !$error_clave && !$error_usuario && !$error_dni && !$error_foto) {
        $clave = md5($clave);
        if ($foto == "") {
            $foto = "img/default.png";
        }

        if (insertar($link, "usuarios", $usuario, $clave, $nombre, $dni, $sexo, $foto)) {
            header("location: funciones.php");
        } else {
            $error_insercion = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear usuario</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <div class="centrar">
        <header>
            <h1>Crear usuario</h1>
        </header>
        <main>
            <?php
            if ($error_insercion) {
                echo "<span style='color:red;font-style: italic;'>Error al insertar los datos, vuleve a intentarlo más tarde</span>";
            }
            ?>
            <form action="create.php" method="post" class="centrar" enctype="multipart/form-data">

                <?php if ($error_nombre) { ?>
                    <span style="color:red;font-style: italic;">El nombre no es válido.</span>
                <?php } ?>
                <div class="input">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
                </div>

                <?php if ($error_usuario) { ?>
                    <span style="color:red;font-style: italic;">El usuario ya existe o no es válido.</span>
                <?php } ?>
                <div class="input">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" value="<?php echo $usuario; ?>">
                </div>

                <?php if ($error_clave) { ?>
                    <span style="color:red;font-style: italic;">La clave debe tener al menos 8 caracteres.</span>
                <?php } ?>
                <div class="input">
                    <label for="clave">Clave</label>
                    <input type="password" name="clave" id="clave">
                </div>

                <?php if ($error_dni) { ?>
                    <span style="color:red;font-style: italic;">El DNI no es válido.</span>
                <?php } ?>
                <div class="input">
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" id="dni" value="<?php echo $dni; ?>">
                </div>

                <div class="input">
                    <label for="sexo">Sexo:</label>
                    <input type="radio" name="sexo" id="sexo" value="Hombre" checked>Hombre
                    <input type="radio" name="sexo" id="sexo" value="Mujer">Mujer
                </div>

                <?php if ($error_foto) { ?>
                    <span style="color:red;font-style: italic;">La foto no es válida.</span>
                <?php } ?>
                <div class="input">
                    <label for="foto">Incluir mi foto:</label>
                    <input type="file" name="foto" id="foto" value="<?php echo $foto; ?>">
                </div>

                <div>
                    <input type="submit" name="crear" value="Crear" class="boton">
                    <input type="submit" formaction="index.php" value="Volver" class="boton">
                </div>

            </form>
        </main>
    </div>
</body>

</html>