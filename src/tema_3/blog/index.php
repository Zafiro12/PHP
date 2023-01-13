<?php
require_once "admin/conexion.php";
require_once "admin/config.php";
session_name("Blog_Curso22_23");
session_start();


function pagina_error($error)
{
    echo "<!DOCTYPE html>
    <html lang='es'>
    
    <head>
        <meta charset='UTF-8'>
        <title>Error</title>
    </head>
    
    <body>
        <h1>Ha ocurrido un error</h1>
        <p>" . $error . "</p>
    </body>
    
    </html>";
    exit();
}

if (isset($_POST["salir"])) {
    session_unset();
}

if (isset($_SESSION["usuario"])) {
    echo "<h1>Bienvenido ".$_SESSION["usuario"]."</h1>";
    ?>
    <form action="index.php" method="post">
        <input type="submit" name="salir" value="Salir">
    </form>
    <?php
} else {
    require_once "views/login.php";
}