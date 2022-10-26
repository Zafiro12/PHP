<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
$array = array('Madrid', 'Barcelona', 'Londres', 'New York', 'Los Angeles', 'Chicago');
foreach ($array as $key => $value) {
    echo "La ciudad con el indice $key tiene el nombre $value. <br>";
}
?>
</body>
</html>