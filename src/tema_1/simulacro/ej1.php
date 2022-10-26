<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio1</title>
</head>
<body>
<form action="ej1.php" method="post">
    <label>Introduce lo que sea:
        <input type="text" name="input" id="input">
    </label>
    <input type="submit" name="enviar" value="Enviar">
    <input type="reset" value="Borrar">
</form>
<?php
function longitud($str): int {
    $n = 0;

    while (true) {
        if ($str[$n] == "") {
            break;
        } else {
            $n++;
        }
    }
    return $n;
}
    if (isset($_POST['enviar'])) {
        $input = 0;
        if (!empty($_POST['input'])) {
            $input = $_POST['input'];
        }

        echo "<hr>";
        echo "<h2>Respuesta:</h2>";

        echo longitud($input);
    }
?>
</body>
</html>