<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <?php
    $simpson = array(
        'padre' => 'Homero',
        'madre' => 'Marge',
        'hijos' => array('Bart', 'Lisa', 'Maggie')
    );

    $griffin = array(
        'padre' => 'Peter',
        'madre' => 'Lois',
        'hijos' => array('Chris', 'Meg', 'Stewie')
    );

    $familias = array(
        'simpson' => $simpson,
        'griffin' => $griffin
    );

    echo "<ul>";
    foreach ($familias as $familia) {
        echo "<li>";
        echo $familia['padre'] . " y " . $familia['madre'] . " tienen a ";
        echo implode(", ", $familia['hijos']);
        echo "</li>";
    }
    echo "</ul>";
    ?>
</body>

</html>