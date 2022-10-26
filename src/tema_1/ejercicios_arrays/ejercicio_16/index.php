<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
$numeros = array(5 => 1, 12 => 2, 13 => 56, 'x' => 42);

echo "<p>". count($numeros) ."</p>";

unset($numeros[5]);

echo "<pre>";
print_r($numeros);
echo "</pre>";

unset($numeros);
?>
</body>
</html>