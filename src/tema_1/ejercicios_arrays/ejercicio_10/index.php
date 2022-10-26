<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
    $numeros = array(1,2,3,4,5,6,7,8,9,10);
    $suma = 0;
    $contador = 0;
    foreach ($numeros as $numero) {
        if ($numero % 2 == 0) {
            $suma += $numero;
            $contador++;
        } else {
            echo $numero . "<br>";
        }
    }
    echo "La media de los pares es: " . $suma / $contador;
?>
</body>
</html>