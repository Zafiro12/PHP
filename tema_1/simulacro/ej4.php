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

$error_tamanio = $_FILES['file']['size'] > 1000000;
$error_tipo = $_FILES['file']['type'] != "text/plain";
$tmp = $_FILES['file']['tmp_name'];
$filename = "horario/horarios.txt";

if (isset($_POST['enviar'])){
    if (!$error_tamanio && !$error_tipo) {
        move_uploaded_file($tmp, $filename);
    }
}

$error_archivo = $error_tamanio || $error_tipo;

if (!$error_archivo) {
    fclose($file);
}

if ((isset($_POST['enviar']) && !$error_archivo && !$error_tamanio && !$error_tipo)||isset($_POST['horarios'])) {
    $ver = false;
    if (isset($_POST['horarios'])) {
        $ver = true;
    }
    ?>
    <h1>EJ 4</h1>
    <form action="ej4.php" method="post">
        <label for="profesores">Elige:</label>
            <select name="profesores" id="profesores">
                <?php
                $file = fopen($filename, "r");
                while (!feof($file)) {
                    $line = fgets($file);
                    if ($line == "") {
                        continue;
                    }
                    $opcion = "";
                    $tamanio= longitud($line);
                    for ($i = 0; $i < $tamanio; $i++) {
                        if ($line[$i] == "\t") {
                            break;
                        }
                        $opcion .= $line[$i];
                    }
                    echo "<option value='$opcion'>$opcion</option>";
                }
                fclose($file);
                ?>
            </select>

        <input type="submit" name="horarios" value="Ver horarios">
<?php
if (isset($_POST['horarios']) && $ver) {
    $profesor = $_POST['profesores'];
    echo "<h3>". $profesor ."</h3>";

    $lunes = [" "," "," "," "," "," "," "];
    $martes = [" "," "," "," "," "," "," "];
    $miercoles = [" "," "," "," "," "," "," "];
    $jueves = [" "," "," "," "," "," "," "];
    $viernes = [" "," "," "," "," "," "," "];

    $file = fopen($filename, "r");
    //todo Horario
}
} else {
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
        echo "<p>El archivo no es válido o no se ha encontrado</p>";
}
}
?>
</body>
</html>