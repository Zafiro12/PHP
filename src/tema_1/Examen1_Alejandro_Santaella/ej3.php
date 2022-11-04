<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio 3</title>
</head>

<body>
    <?php
    $descifrar = isset($_POST["descifrar"]);
    $error_input = false;
    $error_file = false;

    if ($descifrar) {
        $error_input = empty($_POST["input"]);
        $error_file = $_FILES["file"]["size"] > (pow(10, 6) + 25 * pow(10, 3)) || $_FILES["file"]["name"] == "";
    }
    ?>
    <h1>Ejercicio 3. Decodifica una frase</h1>
    <form action="ej3.php" method="post" enctype="multipart/form-data">
        <label for="input">Introduzca un texto: </label>
        <input type="text" name="input" id="input" <?php
                                                    if ($descifrar && !$error_input) {
                                                        echo "value='" . $_POST["input"] . "'";
                                                    }
                                                    ?>> <?php
                                                        if ($descifrar && $error_input) {
                                                            echo "*Campo obligatorio";
                                                        }
                                                        ?>
        <br><br>
        <label for="file">Seleccione el archivo de claves (.txt y menor 1.25MB)</label>
        <input type="file" name="file" id="file" accept=".txt"> <?php
                                                                if ($descifrar && $error_file) {
                                                                    echo "No se ha podido abrir el archivo";
                                                                }
                                                                ?>
        <br><br>
        <input type="submit" name="descifrar" value="Descifrar">
    </form>
    <?php
    function descifrar($file, $m, $j)
    {
        $claves = fopen($file, "r");
        $resultado = "";
        $fila = 1;

        fseek($claves, 15);
        while (!feof($claves)) {
            $linea = fgets($claves);
            $separador = ";";
            $texto = [];
            $pos = 0;
            if ($fila == $j) {
                for ($i = 0; $i < strlen($linea); $i++) {
                    if ($linea[$i] != $separador && !is_numeric($linea[$i])) {
                        $texto[$pos] = $linea[$i];
                        $pos++;
                    }
                }
                $resultado = $texto[$m];
                break;
            }
            $fila++;
        }

        fclose($claves);
        return $resultado;
    }


    if ($descifrar && !$error_file && !$error_input) {
        echo "<h2>Respuesta</h2>";

        $tmp = $_FILES["file"]["tmp_name"];
        $input = $_POST["input"];
        $texto  = "";

        for ($i = 0; $i < strlen($input); $i++) {
            if (is_numeric($input[$i]) && is_numeric(@$input[$i + 1])) {
                $m = $input[$i];
                if ($m == 0) $m++;
                $j = $input[$i];
                if ($j == 0) $j++;

                $texto .= descifrar($tmp, $m, $j);
                $i++;
            } else {
                $texto .= $input[$i];
            }
            
        }
        echo $texto;
    }
    ?>
</body>

</html>