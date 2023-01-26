<?
function editar($link, $tabla, $id, ...$args)
{
    $sql = "SHOW COLUMNS FROM $tabla";
    $columnas = mysqli_query($link, $sql);

    $sql = "UPDATE $tabla SET ";

    while ($col = mysqli_fetch_array($columnas)) {
        if ($col['Field'] != "id_pelicula") {
            $sql .= $col['Field'] . " = '" . array_shift($args) . "', ";
            
        }
    }
    $sql = substr(trim($sql), 0, -1) . " WHERE id_pelicula = $id";
    if (mysqli_query($link, $sql)) {
        return true;
    } else {
        return false;
    }
}

function peliculaRepetida($link, $id, $titulo, $director)
{
    $sql = "SELECT * FROM peliculas WHERE titulo = '$titulo' AND director = '$director' AND id_pelicula != $id";
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
    if (!@move_uploaded_file($tmp_name, $destino)) {
        return false;
    }

    return true;
}

require_once "sql/config.php";

$error_titulo = $error_director = $error_sinopsis = $error_tematica = $error_caratula = $error_edicion = false;
$titulo = $director = $sinopsis = $tematica = $caratula = "";


if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $id = $_GET['id'];
} else if (isset($_POST['id']) && !empty(trim($_POST['id']))) {
    $id = $_POST['id'];
} else {
    die("Algo salió mal. Por favor, inténtelo de nuevo más tarde.");
}

// Coger datos de la pelicula
$sql = "SELECT * FROM peliculas WHERE id_pelicula = $id";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $titulo = $row['titulo'];
        $director = $row['director'];
        $sinopsis = $row['sinopsis'];
        $tematica = $row['tematica'];
        $caratula = $row['caratula'];
    } else {
        die("Algo salió mal. Por favor, inténtelo de nuevo más tarde.");
    }
} else {
    die("Algo salió mal. Por favor, inténtelo de nuevo más tarde.");
}
mysqli_free_result($result);

if (isset($_POST['guardar'])) {
    $titulo = $_POST['titulo'];
    $director = $_POST['director'];
    $sinopsis = $_POST['sinopsis'];
    $tematica = $_POST['tematica'];

    if (empty(trim($titulo))) {
        $error_titulo = true;
    }

    if (empty(trim($director))) {
        $error_director = true;
    }

    if (empty(trim($sinopsis))) {
        $error_sinopsis = true;
    }

    if (empty(trim($tematica))) {
        $error_tematica = true;
    }

    if (isset($_FILES['caratula']) && !empty($_FILES['caratula']['name'])) {
        $uniqueID = uniqid();
        if (!transaccionCaratula($_FILES['caratula'], $uniqueID)) {
            $error_caratula = true;
        } else {
            $caratula = "img/" . $uniqueID . "." . pathinfo($_FILES['caratula']['name'], PATHINFO_EXTENSION);
        }
    }

    if (!peliculaRepetida($link, $id, $titulo, $director)) {
        if (!$error_titulo && !$error_director && !$error_sinopsis && !$error_tematica && !$error_caratula) {

            if ($caratula == "") {
                $caratula = "img/default.png";
            }

            if (editar($link, "peliculas", $id, $titulo, $director, $sinopsis, $tematica, $caratula)) {
                header("location: funciones.php");
            } else {
                $error_edicion = true;
            }
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
            <h1>Editando pelicula <?php echo $id . PHP_EOL; ?></h1>
        </header>
        <main>
            <?php
            if ($error_edicion) {
                echo "<span style='color:red;font-style: italic;'>Error al editar los datos, vuelve a intentarlo más tarde</span>";
            }
            ?>
            <form action="update.php" method="post" class="centrar" enctype="multipart/form-data">

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
                    <img src="<?php echo $caratula ?>" alt="caratula" height="100px" title="caratula"><br><br>
                    <input type="file" name="caratula" id="caratula" value="<?php echo $caratula; ?>">
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