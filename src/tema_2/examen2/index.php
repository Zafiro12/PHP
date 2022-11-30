<?php
session_start();
require_once 'src/config.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 PHP</title>
</head>

<body>
    <h1>Examen2 PHP</h1>
    <h2>Horario de los Profesores</h2>
    <form action="index.php" method="post">
        <label for="profesor">Horario del profesor:</label>
        <select name="usuario" id="profesor">
            <?php
            $sql = "SELECT * FROM usuarios";
            $result = mysqli_query($link, $sql);
            while ($row = mysqli_fetch_array($result)) {
                echo "<option value='" . $row['id_usuario'] . "'>" . $row['nombre'] . "</option>";
            }
            mysqli_free_result($result);
            ?>
        </select>
        <input type="submit" value="Ver horario">
    </form>
</body>

</html>