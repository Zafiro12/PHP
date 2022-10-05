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
        $palabra = strtolower($palabra);
        if (is_numeric($palabra)) {
            if (strrev($palabra) == $palabra) {
            echo "<p>El numero $palabra es capicuo</p>";
        } else {
            echo "<p>El numero $palabra no es capicuo</p>";
        }
        } else {
            if ($palabra == strrev($palabra)) {
                echo "<p>La palabra introducida es un palíndromo</p>";
            } else {
                echo "<p>La palabra introducida no es un palíndromo</p>";
            }
        }
    }
    ?>
</body>

</html>