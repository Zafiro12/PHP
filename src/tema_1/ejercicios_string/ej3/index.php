<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <form action="index.php" method="post">
        <label for="frase">Introduce una frase:</label>
        <input type="text" name="frase" id="frase" required value="<?php
        if (isset($_POST['frase'])) {
            echo $_POST['frase'];
        } else {
            echo "";
        }
    ?>">
        <input type="submit" value="Comprobar" name="submit">
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $frase = $_POST['frase'];
        $frase = strtolower($frase);
        
        // comprueba si la frase es un palíndromo
        if ($frase == strrev($frase)) {
            echo "<p>La frase introducida es un palíndromo</p>";
        } else {
            echo "<p>La frase introducida no es un palíndromo</p>";
        }
    }
    ?>
</body>

</html>