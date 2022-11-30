<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERROR</title>
</head>

<body>
    <?php
    /* Credenciales */
    define('DB_SERVER', 'db');
    define('DB_USERNAME', 'jose');
    define('DB_PASSWORD', 'josefa');
    define('DB_NAME', 'bd_horarios_exam');

    /* Intento de conexion */
    @$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($link === false) {
        die("<h1>ERROR: No se pudo conectar.</h1><p><strong>Mensaje de error: </strong>" . mysqli_connect_error() . "</p>");
    }
    ?>
</body>

</html>