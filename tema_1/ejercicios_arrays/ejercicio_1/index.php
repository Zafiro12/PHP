<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
$array = array();
for ($i = 2; count($array) != 10; $i = $i + 2) {
    $array[$i] = $i;
}
foreach ($array as $value) {
    echo $value . "<br>";
}
?>
</body>
</html>