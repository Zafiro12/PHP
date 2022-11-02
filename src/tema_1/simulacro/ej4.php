<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio 4</title>
</head>

<body>
    <?php
    function longitud($str): int
    { // Misma función que strlen
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

    $subirArchivo = isset($_POST["subirArchivo"]);
    $error_archivo = false;

    if ($subirArchivo) {
        $error_archivo = $_FILES["file"]["name"] != "horarios2.txt" || $_FILES["file"]["size"] > 1000000 || $_FILES["file"]["type"] != "text/plain";
        if (!$error_archivo) {
            move_uploaded_file($_FILES["file"]["tmp_name"], "Horario/horarios2.txt");
        }
    }

    @$comprobar = fopen("Horario/horarios2.txt", "r");

    if (!$comprobar) {
    ?>
        <h1>Ejercicio 4</h1>
        <form action="ej4.php" method="post" enctype="multipart/form-data">
            <h2>No se encuentra el archivo Horario/horarios2.txt</h2>
            <label for="file">Seleccione un archivo txt no superior a 1MB:</label>
            <input type="file" name="file" id="file"><br>
            <input type="submit" name="subirArchivo" value="subir">
        </form>
    <?php
    } else {
        fclose($comprobar);
    ?>
        <h1>Ejercicio 4</h1>
        <form action="ej4.php" method="post">
            <label for="profesor">Horario del Profesor</label>
            <select name="profesor" id="profesor">
                <?php
                    $file = fopen("Horario/horarios.txt", "r");

                    while(!feof($file)) {
                        $line = fgets($file);
                        
                    }
                    fclose($file);
                ?>
            </select>
        </form>
    <?php
    }
    ?>
</body>

</html>