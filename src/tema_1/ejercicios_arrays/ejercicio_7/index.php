<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
// Los indices y los valores estan al reves
$array = array('Madrid' => 'MD', 'Barcelona' => 'BCN', 'Londres' => 'LON', 'New York' => 'NY', 'Los Angeles' => 'LA', 'Chicago' => 'CHI');
foreach ($array as $key => $value) {
    echo "El indice de la ciudad $key es $value. <br>";
}
?>
</body>
</html>