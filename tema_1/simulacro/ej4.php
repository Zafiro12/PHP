<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 4</title>
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
$filename = "./horario/horarios.txt";
$file = fopen($filename, "r");
$error_archivo = !$file;
if (!$error_archivo) {
    fclose($file);
}
$error_tamanio = 0;
$error_tipo = 0;

if (isset($_POST['enviar'])){
    $error_tamanio = $_FILES['file']['size'] > 1000000;
    $error_tipo = $_FILES['file']['type'] != "text/plain";
}
if (isset($_POST['enviar']) && !$error_archivo && !$error_tamanio && !$error_tipo) {
    ?>
    <h1>EJ 4</h1>
    <form action="ej4.php" method="post">
        <label>Elige:
            <select name="profesores" id="profesores">
                <?php
                $file = fopen($filename, 'r');
                while (!feof($file)) {
                    $line = fgets($file);
                    $nombre = "";
                    for ($i = 0; $i < longitud($line); $i++) {
                        if ($line[$i] == "\t") {
                            break;
                        }
                        $nombre += $line[$i];
                    }
                    echo "<option value='$nombre'>$nombre</option>";
                }
                fclose($file);
                ?>
            </select>
        </label>
        <input type="submit" name="horarios" value="Ver horarios">
<?php
}
?>
<h1>EJ 4</h1>
<form action="ej4.php" method="post" enctype="multipart/form-data">
    <label>Sube un archivo:
        <input type="file" name="file" id="file">
        <input type="submit" name="enviar" value="Enviar">
    </label>
</form>

<?php
if ($error_archivo) {
        echo "<p>No se ha podido encontrar el archivo</p>";
}
if (isset($_POST['enviar'])) {

    if ($error_tamanio) {
        echo "<p>El archivo es demasiado grande</p>";
    }
    if ($error_tipo) {
        echo "<p>El archivo no es de texto</p>";
    }
    if (!$error_tamanio && !$error_tipo) {
        $nombre = $_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];
        move_uploaded_file($tmp, "horario/$nombre");
    }
}
?>
</body>
</html>