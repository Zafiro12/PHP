<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
$meses['enero'] = 9;
$meses['febrero'] = 12;
$meses['marzo'] = 0;
$meses['abril'] = 17;

foreach ($meses as $key => $value) {
    if ($value > 0) {
        echo "En el mes de $key se vendieron $value productos.<br>";
    }
}
?>
</body>
</html>