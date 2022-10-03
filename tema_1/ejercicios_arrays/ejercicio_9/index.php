<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
$lenguajes_cliente = array('HTML' => 'Hypertext Markup Language', 'CSS' => 'Cascading Style Sheets', 'JS' => 'JavaScript', 'PHP' => 'PHP: Hypertext Preprocessor');
$lenguajes_servidor = array('PHP' => 'PHP: Hypertext Preprocessor', 'ASP' => 'Active Server Pages', 'JSP' => 'Java Server Pages', 'CF' => 'ColdFusion');
$lenguajes = array_merge($lenguajes_cliente, $lenguajes_servidor);

echo "<table border='1'>";
echo "<tr><th>Lenguaje</th><th>Descripción</th></tr>";
foreach ($lenguajes as $key => $value) {
    echo "<tr><td>$key</td><td>$value</td></tr>";
}
echo "</table>";
?>
</body>
</html>