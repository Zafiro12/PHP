<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>

<body>
    <form action="ej1.php" method="post">
        <input type="text" name="input1">
        <input type="text" name="input2">
        <input type="submit" name="enviar" value="Pulsame">
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
	$input1 = 0;
    $input2 = 0;
    
    $input1 = $_POST['input1'];
    $input2 = $_POST['input2'];

    $bool = esSubstr($input1, $input2);

    if ($bool) {
        echo "es substring";
    } else {
        echo "no es substring";
    }
    ?>
</body>

</html>
