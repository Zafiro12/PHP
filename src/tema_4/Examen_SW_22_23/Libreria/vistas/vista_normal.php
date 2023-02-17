<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vista Normal</title>
</head>
<body>
<h1>Librería</h1>
<h2>Bienvenido <?php echo $_SESSION["usuario"] ?></h2>
<form action="index.php" method="post">
    <input type="submit" name="logout" value="Salir">
</form>
<h2>Listado de los libros</h2>
<div style="display: flex;flex-flow: row wrap; justify-content: flex-start; width: 100%;">
    <?php
    getLibros();
    ?>
</div>

</body>
</html>
