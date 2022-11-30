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

function transaccionCaratula($file, $uniqueID)
{
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

function peliculaRepetida($link, $titulo, $director)
{
    $sql = "SELECT * FROM peliculas WHERE titulo = '$titulo' AND director = '$director'";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

require_once "sql/config.php";

$error_titulo = $error_director = $error_sinopsis = $error_tematica = $error_caratula = $error_insercion = false;
$titulo = $director = $sinopsis = $tematica = $caratula = "";

if (isset($_POST['insertar'])) {

    if (empty(trim($_POST['titulo']))) {
        $error_titulo = true;
    } else {
        $titulo = trim($_POST['titulo']);
    }

    if (empty(trim($_POST['director']))) {
        $error_director = true;
    } else {
        $director = trim($_POST['director']);
    }

    if (empty(trim($_POST['sinopsis']))) {
        $error_sinopsis = true;
    } else {
        $sinopsis = trim($_POST['sinopsis']);
    }

    if (empty(trim($_POST['tematica']))) {
        $error_tematica = true;
    } else {
        $tematica = trim($_POST['tematica']);
    }

    if (!$error_titulo && !$error_director && !$error_sinopsis && !$error_tematica) {
        if (!peliculaRepetida($link, $titulo, $director)) {
            if (isset($_FILES['caratula']) && !empty($_FILES['caratula']['name'])) {
                $uniqueID = uniqid();
                if (!transaccionCaratula($_FILES['caratula'], $uniqueID)) {
                    $error_caratula = true;
                } else {
                    $caratula = "img/" . $uniqueID . "." . pathinfo($_FILES['caratula']['name'], PATHINFO_EXTENSION);
                }
            }

            if (!$error_caratula) {
                if ($caratula == "") {
                    $caratula = "img/default.png";
                }

                if (insertar($link, "peliculas", $titulo, $director, $sinopsis, $tematica, $caratula)) {
                    header("location: index.php");
                } else {
                    $error_insercion = true;
                }
            }
        } else {
            $error_titulo = $error_director = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Insertar pelicula</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <div class="centrar">
        <header>
            <h1>Insertar pelicula</h1>
        </header>
        <main>
            <?php
            if ($error_insercion) {
                echo "<span style='color:red;font-style: italic;'>Error al insertar los datos, vuleve a intentarlo más tarde</span>";
            }
            ?>
            <form action="create.php" method="post" class="centrar" enctype="multipart/form-data">

                <?php if ($error_titulo) { ?>
                    <span style="color:red;font-style: italic;">El titulo no es válido.</span>
                <?php } ?>
                <div class="input">
                    <label for="titulo">Titulo</label>
                    <input type="text" name="titulo" id="titulo" value="<?php echo $titulo; ?>">
                </div>

                <?php if ($error_director) { ?>
                    <span style="color:red;font-style: italic;">El director no es válido.</span>
                <?php } ?>
                <div class="input">
                    <label for="director">Director</label>
                    <input type="text" name="director" id="director" value="<?php echo $director; ?>">
                </div>

                <?php if ($error_sinopsis) { ?>
                    <span style="color:red;font-style: italic;">La sinopsis no es válida.</span>
                <?php } ?>
                <div class="input">
                    <label for="sinopsis">Sinopsis</label>
                    <textarea name="sinopsis" id="sinopsis" cols="30" rows="10"><?php echo $sinopsis; ?></textarea>
                </div>

                <?php if ($error_tematica) { ?>
                    <span style="color:red;font-style: italic;">La temática no es válida.</span>
                <?php } ?>
                <div class="input">
                    <label for="tematica">Tematica</label>
                    <input type="text" name="tematica" id="tematica" value="<?php echo $tematica; ?>">
                </div>

                <?php if ($error_caratula) { ?>
                    <span style="color:red;font-style: italic;">La carátula no es válida.</span>
                <?php } ?>
                <div class="input">
                    <label for="caratula">Caratula:</label>
                    <input type="file" name="caratula" id="caratula" value="<?php echo $caratula; ?>">
                </div>

                <div>
                    <input type="submit" name="insertar" value="Insertar" class="boton">
                    <input type="submit" formaction="index.php" value="Volver" class="boton">
                </div>

            </form>
        </main>
    </div>
</body>

</html>