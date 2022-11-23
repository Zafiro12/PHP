<?php
/* Credenciales */
define('DB_SERVER', 'db');
define('DB_USERNAME', 'jose');
define('DB_PASSWORD', 'josefa');
define('DB_NAME', 'bd_videoclub');
 
/* Intento de conexion */
@$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($link === false){
    die("ERROR: No se pudo conectar. " . mysqli_connect_error());
}