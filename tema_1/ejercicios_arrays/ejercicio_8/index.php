<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
$array = array('Pedro', 'Ismael', 'Sonia', 'Clara', 'Susana', 'Alfonso', 'Teresa');
echo "El array tiene " . count($array) . " elementos. <br>";
echo "<ul>";
foreach ($array as $key => $value) {
    echo "<li>$value</li>";
}
echo "</ul>";
?>
</body>
</html>