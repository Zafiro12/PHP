<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <?php
    $deportes = array('futbol', 'baloncesto', 'natacion', 'tenis');
    
    echo "<ul>";
    for ($i = 0; $i < count($deportes); $i++) {
        echo "<li>" . $deportes[$i] . "</li>";
    }
    echo "</ul>";

    echo count($deportes)."<br>";

    echo key($deportes)."<br>";

    next($deportes);
    echo key($deportes)."<br>";

    end($deportes);
    echo key($deportes)."<br>";

    prev($deportes);
    echo key($deportes)."<br>";
    ?>
</body>

</html>