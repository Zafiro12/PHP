<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 2</title>
</head>
<body>
<?php
function longitud($str): int {
    $n = -1;

    while (true) {
        if ($str[$n] == "") {
            break;
        } else {
            $n++;
        }
    }
    return $n;
}

$error_archivo = 0;
$error_tamanio = 0;
$error_tipo = 0;

if (isset($_POST['enviar'])){
    $error_archivo = $_FILES['file']['error'] != 0;
    $error_tamanio = $_FILES['file']['size'] > 1000000;
    $error_tipo = $_FILES['file']['type'] != "text/plain";
}
?>

<form action="ej2.php" method="post" enctype="multipart/form-data">
    <label>Sube un archivo:
        <input type="file" name="file" id="file">
        <input type="submit" name="enviar" value="Enviar">
    </label>
</form>

<?php
if (isset($_POST['enviar'])) {
    if ($error_archivo) {
        echo "<p>El archivo no se ha podido subir</p>";
    }
    if ($error_tamanio) {
        echo "<p>El archivo es demasiado grande</p>";
    }
    if ($error_tipo) {
        echo "<p>El archivo no es de texto</p>";
    }
    if (!$error_archivo && !$error_tamanio && !$error_tipo) {
        $nombre = $_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];
        $contenido = file_get_contents($tmp);
        $longitud = longitud($contenido);
        echo "<p>Nombre: $nombre</p>";
        echo "<p>Longitud: " .$longitud - 1 ."</p>";
        move_uploaded_file($tmp, "Ficheros/$nombre");
        echo "<p>Archivo guardado en Ficheros</p>";
    }
}
?>
</body>
</html>