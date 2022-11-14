<?
function editar($link, $tabla, $id, ...$args)
{
    //coger el nombre de las columnas
    $sql = "SHOW COLUMNS FROM $tabla";
    $columnas = mysqli_query($link, $sql);
    $sql = "UPDATE $tabla SET ";
    //salta la primera columna que es el id
    $columnas->fetch_assoc();
    $i = 0;
    while ($columna = $columnas->fetch_assoc()) {
        $sql .= $columna['Field'] . " = '" . $args[$i] . "',";
        $i++;
    }
    $sql = substr($sql, 0, -1) . " WHERE id = $id";
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

function comprobarEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 30) {
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

function comprobarUsuario($link, $usuario, $id)
{
    if (strlen($usuario) < 3 || strlen($usuario) > 20) {
        return false;
    }

    // Primero miramos si se ha cambiado el usuario, si no, no hay que comprobarlo
    $sql = "SELECT usuario FROM usuarios WHERE id = $id";
    if ($result = mysqli_query($link, $sql)) {
        $row = mysqli_fetch_assoc($result);
        if ($row['usuario'] == $usuario) {
            return true;
        }
    }
    
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            return false;
        }
        return true;
    }
}

require_once "config.php";

$error_nombre = $error_email = $error_clave = $error_usuario = $error_edicion = false;
$id = $nombre = $email = $clave = $usuario = "";

if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $id = $_GET['id'];
} else if (isset($_POST['id']) && !empty(trim($_POST['id']))) {
    $id = $_POST['id'];
} else {
    die("Algo salió mal. Por favor, inténtelo de nuevo más tarde.");
}

// Coger datos del usuario
$sql = "SELECT * FROM usuarios WHERE id = $id";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $nombre = $row['nombre'];
        $email = $row['email'];
        $clave = $row['clave'];
        $usuario = $row['usuario'];
    } else {
        die("Algo salió mal. Por favor, inténtelo de nuevo más tarde.");
    }
} else {
    die("Algo salió mal. Por favor, inténtelo de nuevo más tarde.");
}

if (isset($_POST['guardar'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $clave = $_POST['clave'];
    $usuario = $_POST['usuario'];
    if (!comprobarNombre($nombre)) {
        $error_nombre = true;
    }
    if (!comprobarEmail($email)) {
        $error_email = true;
    }
    if (!comprobarClave($clave)) {
        $error_clave = true;
    }
    if (!comprobarUsuario($link, $usuario, $id)) {
        $error_usuario = true;
    }
    if (!$error_nombre && !$error_email && !$error_clave && !$error_usuario) {
        $clave = md5($clave);
        if (editar($link, "usuarios", $id, $nombre, $email, $usuario, $clave)) {
            header("location: index.php");
        } else {
            $error_edicion = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <div class="centrar">
        <header>
            <h1>Editar usuario</h1>
        </header>
        <main>
            <?php
            if ($error_edicion) {
                echo "<span style='color:red;font-style: italic;'>Error al editar los datos, vuleve a intentarlo más tarde</span>";
            }
            ?>
            <form action="update.php" method="post" class="centrar">

                <?php if ($error_nombre) { ?>
                    <span style="color:red;font-style: italic;">El nombre debe tener al menos 3 caracteres.</span>
                <?php } ?>
                <div class="input">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
                </div>

                <?php if ($error_email) { ?>
                    <span style="color:red;font-style: italic;">El email no es válido.</span>
                <?php } ?>
                <div class="input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo $email; ?>">
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

                <div class="input">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                </div>

                <div>
                    <input type="submit" name="guardar" value="Guardar" class="boton">
                    <input type="submit" formaction="index.php" value="Volver" class="boton">
                </div>

            </form>
        </main>

    </div>

</body>

</html>