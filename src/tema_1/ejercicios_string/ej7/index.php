<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <form action="index.php" method="post">
        <label for="numero">Introduce un número:</label>
        <input type="text" name="numero" id="numero" required value="<?php
        if (isset($_POST['numero'])) {
            echo $_POST['numero'];
        } else {
            echo "";
        }
    ?>">
        <input type="submit" value="Convertir" name="submit">
    </form>
    <?php
    if (isset($_POST['submit'])) {
        if (preg_match('/^[0-9]+,[0-9]+$/', $_POST['numero'])) {
            $numero = $_POST['numero'];
            $numero = str_replace(',', '.', $numero);
            echo "<p>El número corregido es: $numero</p>";
        } else {
            echo "<p>El valor introducido no es válido</p>";
        }
    }
    ?>
</body>

</html>