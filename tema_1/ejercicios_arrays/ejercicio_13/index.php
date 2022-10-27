<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
$arr1 = array('Lagartija', 'Araña', 'Perro', 'Gato', 'Ratón');
$arr2 = array(12,34,52,12);
$arr3 = array('Sauce', 'Pino', 'Naranjo', 'Chopo', 'Perro', 34);
$arr4 = array();

foreach ($arr1 as $i) {
    array_push($arr4, $i);
}

foreach ($arr2 as $i) {
    array_push($arr4, $i);
}

foreach ($arr3 as $i) {
    array_push($arr4, $i);
}

$arr4 = array_reverse($arr4);

print_r($arr4);
?>
</body>
</html>