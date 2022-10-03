<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <form action="index.php" method="post">
        <label for="palabra">Introduce una palabra:</label>
        <input type="text" name="palabra" id="palabra" required>
        <input type="submit" value="Comprobar" name="submit">
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $palabra = $_POST['palabra'];
        if (strrev($palabra) == $palabra) {
            echo "<p>La palabra $palabra es palindromo</p>";
        } else {
            echo "<p>La palabra $palabra no es palindromo</p>";
        }
    }
    ?>
</body>

</html>