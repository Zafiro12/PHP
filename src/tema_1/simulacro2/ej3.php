<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
</head>

<body>
    <form action="ej3.php" method="post" enctype="multipart/form-data">
        <input type="submit" name="enviar" value="Enviar">
    </form>
    <?php
    function esSubstr($texto1, $texto2)
    {
        for ($i = 0; $i < strlen($texto1); $i++) {
            if ($texto1[$i] == $texto2[0]) {
                for ($j = 0; $j < strlen($texto2); $j++) {
                    if ($texto1[$i + $j] != $texto2[$j]) {
                        break;
                    }
                    if ($j == strlen($texto2) - 1 && $texto1[$i + $j] == $texto2[$j]) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    function decesar($texto, $des)
    {
        for ($i = 0; $i < strlen($texto); $i++) {
            $letra = $texto[$i];
            if (ord($letra) <= ord('Z') && ord($letra) >= ord('A')) {
                if (ord($letra) + $des > ord('Z')) {
                    $letra = ord('A') + ((ord($letra) + $des) - ord('Z')) - 1;
                } else {
                    $letra = ord($letra) + $des;
                }
                $texto[$i] = chr($letra);
            }
        }
        return $texto;
    }

    function decodificar($file)
    {
        $fp = fopen($file, "r");
        $max = ord('Z') - ord('A');
        $fin = false;
        $cod = 0;

        for ($i = 1; $i < $max; $i++) {
            while (!feof($fp)) {
                $texto = fgets($fp);
                $texto = decesar($texto, $i);
                if (esSubstr($texto, "FELIX")) {
                    $fin = true;
                    $cod = $i;
                    break;
                }
            }
            if ($fin) {
                break;
            }
            fseek($fp, 0);
        }
        

        if ($fin) {
            $destino = fopen("decodificado.txt", "w"); 
            fseek($fp, 0);
            while (!feof($fp)) {
                $texto = fgets($fp);
                $texto = decesar($texto, $cod);
                
                fputs($destino,$texto.PHP_EOL);
            }
            fputs($destino, "Decodificado el " . date("d/m/y") . PHP_EOL);
            fclose($destino);
            echo "Decodificado!" . PHP_EOL;
        }
    
        fclose($fp);
        
    }
    if (isset($_POST['enviar'])) {
        echo "Decodificando texto..." . PHP_EOL;
        decodificar("./codificado.txt");
    }
    ?>
</body>

</html>