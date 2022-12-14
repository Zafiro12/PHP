<?php
/* Credenciales */
define('DB_SERVER', 'db');
define('DB_USERNAME', 'jose');
define('DB_PASSWORD', 'josefa');
define('DB_NAME', 'bd_usuarios');

/* Intento de conexion */
@$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($link === false) {
    die("<h1>ERROR: No se pudo conectar.</h1><p><strong>Mensaje de error: </strong>" . mysqli_connect_error() . "</p>");
}
