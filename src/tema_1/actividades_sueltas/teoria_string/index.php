<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Teoría strings</title>
</head>

<body>
    <?php
    $texto1 = "Hola";
    $texto2 = "Mundo";

    echo "<h1>$texto1 $texto2</h1>";

    echo strlen($texto1);

    echo "<p> $texto1[1] </p>";

    echo strtolower($texto1)."<br><br>";

    $arr = explode(" ", $texto1." ".$texto2);

    print_r($arr);

    echo "<br><br>";

    echo implode(" ", $arr);

    echo "<br><br>";
    ?>
</body>

</html>