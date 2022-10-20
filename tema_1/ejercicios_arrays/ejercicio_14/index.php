<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
$estadios_futbol = array('Barcelona' => 'Camp Nou', 
'Real Madrid' => 'Santiago Bernabeu', 
'Valencia' => 'Mestalla');

echo "<table border='1'>";
echo "<tr><th>Equipo</th><th>Estadio</th></tr>";
foreach ($estadios_futbol as $key => $value) {
    echo "<tr><td>$key</td><td>$value</td></tr>";
}
echo "</table>";
echo '<br>';

unset($estadios_futbol['Real Madrid']);

echo "<ol>";
echo "<h3>Equipo | Estadio<h3>";
foreach ($estadios_futbol as $key => $value) {
    echo "<li>$key: $value</li>";
}
echo "</ol>";
?>
</body>
</html>