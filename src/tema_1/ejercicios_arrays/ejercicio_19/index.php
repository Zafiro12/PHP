<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <?php
    $amigos = array(
        'Madrid' => array(
            'amigo1' => array(
                'nombre' => 'Pedro',
                'edad' => 32,
                'telefono' => '123456789'
            )
        ),
        'Barcelona' => array(
            'amigo1' => array(
                'nombre' => 'Susana',
                'edad' => 34,
                'telefono' => '987654321'
            )
        ),
        'Toledo' => array(
            'amigo1' => array(
                'nombre' => 'Sonia',
                'edad' => 42,
                'telefono' => '123987456'
            )
        )
    );

    echo "<pre>";
    print_r($amigos);
    echo "</pre>";
    ?>
</body>

</html>