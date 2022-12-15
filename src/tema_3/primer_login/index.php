<?php
require_once "assets/config.php";

session_name("loginUsuario");
session_start();

$tiempo = (isset($_SESSION['time'])) ? $_SESSION['time'] : strtotime(date("Y-m-d H:i:s"));
$actual =  strtotime(date("Y-m-d H:i:s"));
(($actual - $tiempo) >= 600) ? header("Location: index.php?salir=true") : $_SESSION['time'] = $actual;

if (isset($_GET['salir'])) {
    session_destroy();
    header("Location: index.php");
}

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $sql = "SELECT nombre FROM usuarios WHERE email = '$email'";
    if ($resultado = mysqli_query($link, $sql)) {
        $fila = mysqli_fetch_assoc($resultado);
        $nombre = $fila['nombre'];
        echo "<h1>Bienvenido $nombre</h1>";
        echo "<a href='index.php?salir=true'>Cerrar sesión</a>";

        mysqli_free_result($resultado);
    } else {
        echo "<h1>Ha ocurrido un error:</h1>" . PHP_EOL . mysqli_error($link);
        echo "<a href='index.php?salir=true'>Volver</a>";
    }
} elseif (isset($_POST['registro']) || isset($_POST['registrarse'])) {
    require "views/register.php";
} else {
    require "views/login.php";
}
