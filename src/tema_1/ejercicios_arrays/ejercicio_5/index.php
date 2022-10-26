<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
$array = array('Nombre' => 'Pedro', 'Direccion' => 'C/Mayor 37', 'Telefono' => 123456789);
foreach ($array as $key => $value) {
    echo "$key: $value<br>";
}
?>
</body>
</html>