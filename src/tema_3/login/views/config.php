<?php
    define('DB_SERVER', 'db');
    define('DB_USERNAME', 'jose');
    define('DB_PASSWORD', 'josefa');
    define('DB_NAME', 'bd_usuarios');

    try
    {
        $conexion = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
        
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        error_page($e);
    }