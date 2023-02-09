<?php
/* Credenciales */
const DB_SERVER = 'db';
const DB_USERNAME = 'jose';
const DB_PASSWORD = 'josefa';
const DB_NAME = 'bd_foro';

/* Intento de conexion */
@$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($link === false) {
    die("<h1>ERROR: No se pudo conectar.</h1><p><strong>Mensaje de error: </strong>" . mysqli_connect_error() . "</p>");
}
