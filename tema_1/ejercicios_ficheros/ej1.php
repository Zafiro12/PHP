<?php
$error_numero = empty($_POST["numero"]) || is_nan($_POST["numero"]) || 1 > $_POST["numero"] || 10 < $_POST["numero"];
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>ej1</title>
        <style>
            body{
                display: block;
            }
        </style>
    </head>
    <body>
        <form action="ej1.php" method="post">
            <label>Introduce un número del 1 al 10:
            <input type="number" name="numero">
            </label>
            <input type="submit" name="enviar" value="Enviar">
            <?php echo $error_numero ? "(el valor introducido no es válido, debe estar entre 1 y 10)" : '' ?>
        </form>
        <?php
        if (isset($_POST["numero"]) && !$error_numero) {
            echo "<hr>";
            echo "El número escrito es: ".$_POST["numero"]."<br>";

            $filename = "Tablas/tabla_". $_POST["numero"] .".txt"; // No se puede crear una carpeta
            $n = 1;
            $fichero = fopen($filename, 'w+');

            while($n<=10){
                fwrite($fichero, $_POST["numero"] ."x". $n ."=". $_POST["numero"]*$n .PHP_EOL);
                $n++;
            }
            fclose($fichero);

            echo "El archivo se encuentra en: <a href='$filename'>$filename</a>";
        }
        ?>
    </body>
</html>
