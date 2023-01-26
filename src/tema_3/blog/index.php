<?php
require_once "admin/config.php";
session_name("Blog_Curso22_23");
session_start();

if (isset($_POST["salir"])) {
    session_unset();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else if (isset($_POST["id"])) {
    $id = $_POST["id"];

    if (isset($_POST["comentario"]) && $_POST["comentario"] != "") {
        $array = array($_POST["comentario"], $_POST["idUsuario"], $id);

        $consulta = "INSERT INTO comentarios (comentario, idUsuario, idNoticia) VALUES (?, ?, ?)";
        ejecutar_consulta($consulta, $array);
    }

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
<hr>
<?php
if (isset($id)) {
    $consulta = "select * from noticias n, usuarios u, categorias c where n.idNoticia = ? and n.idUsuario = u.idUsuario and n.idCategoria = c.idCategoria";
    $noticia = ejecutar_consulta($consulta, array($id))->fetch(PDO::FETCH_ASSOC);

    echo "<h2>" . $noticia["titulo"] . "</h2>";
    echo "<h3>" . $noticia["copete"] . "</h3>";
    echo "<small>Noticia por <u>" . $noticia["usuario"] . "</u> en <i>" . $noticia["valor"] . "</i></small>";
    echo "<p>" . $noticia["cuerpo"] . "</p>";
    echo "<hr>";
    echo "<h2>Comentarios</h2>";

    $consulta = "select * from comentarios c, usuarios u where c.idNoticia = ? and c.idUsuario = u.idUsuario";
    $comentarios = ejecutar_consulta($consulta, array($id))->fetchAll(PDO::FETCH_ASSOC);

    foreach ($comentarios as $comentario) {
        echo "<h3>" . $comentario["usuario"] . "</h3>";
        echo "<p>" . $comentario["comentario"] . "</p>";
        echo "<hr>";
    }

    if (isset($_SESSION["usuario"])) {
        echo "<h2>Deja tu comentario</h2>";

        $consulta = "select * from usuarios where usuario = ?";
        $usuario = ejecutar_consulta($consulta, array($_SESSION["usuario"]))->fetch(PDO::FETCH_ASSOC);

        ?>
        <form action="index.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="idUsuario" value="<?php echo $usuario["idUsuario"]; ?>">
            <p>
                <label for="comentario" hidden>
                    Comentario
                </label>
                <textarea name="comentario" id="comentario" cols="30" rows="10" style="resize: none"></textarea>
            </p>

            <input type="submit" value="Publicar">
            <hr>
        </form>
        <?php
    }

    echo "<form action='funciones.php'>";
    echo "<button type='submit'>Salir</button>";
    echo "</form>";
} else {
    $consulta = "SELECT * FROM noticias";
    $noticias = ejecutar_consulta($consulta)->fetchAll(PDO::FETCH_ASSOC);

    foreach ($noticias as $noticia) {
        echo "<h2><a href='funciones.php?id=" . $noticia["idNoticia"] . "'>" . $noticia["titulo"] . "</a></h2>";
        echo "<p>" . $noticia["copete"] . "</p>";
    }
}
?>
</body>
</html>
