<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Nombre 1</title>
</head>
<body>
    <p></p>
    <?php
        if (isset($_SESSION['nombre']) && $_SESSION['nombre'] != "") {
            echo "<p>Nombre: <strong>" . $_SESSION['nombre'] . "</strong></p>";
        }
    ?>
    <form action="receptor.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre"><br><br>
        <input type="reset" value="Borrar">
        <input type="submit" value="Siguiente">
    </form>
</body>
</html>