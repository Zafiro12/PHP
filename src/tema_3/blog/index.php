<?php
require_once "admin/Conexion.php";
require_once "admin/config.php";
require_once "admin/clases/Noticias.php";
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
    require_once "views/seguridad.php";

    echo "<h1>Bienvenido " . $_SESSION["usuario"] . "</h1>";
    ?>
    <form action="index.php" method="post">
        <input type="submit" name="salir" value="Salir">
    </form>
    <?php
} else {
    require_once "views/login.php";
}
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Noticias</title>
</head>
<body>
<?php
$conexion = new Conexion(HOST, DB, USER, PASSWORD);
$noticias = new  Noticias($conexion->conectar());

if (!isset($_GET["id"])) {
    $noticias = $noticias->todos();

    foreach ($noticias as $noticia) {
        echo "<h1><a href='index.php?id=".$noticia["idNoticia"]."'>".$noticia["titulo"]."</a></h1>";
        echo "<p>".$noticia["copete"]."</p>";
    }
} else {
    $noticias = $noticias->buscarId($_GET["id"]);

    echo "<h1>".$noticias["titulo"]."</h1>";
    echo "<h3>".$noticias["copete"]."</h3>";
    echo "<p>".$noticias["cuerpo"]."</p>";
    echo "<button><a href='index.php'>Salir</a></button>";
}
?>
</body>
</html>
