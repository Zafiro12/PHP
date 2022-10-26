<?php
if (isset($_POST["enviar"])){
    $error_input = empty($_POST["input"] || $_POST["input"] == "0") || !is_numeric($_POST["input"]);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario</title>
</head>
<body>
    <form action="index.php" method="post">
        <label>Introduce tu edad:
            <input type="text" name="input">
        </label>
        <label>
            <input type="radio" name="estado" id="estudiante" value="estudiante">Estudiante
        </label>
        <label>
            <input type="radio" name="estado" id="otro" value="otro">Otro
        </label>
        <input type="submit" name="enviar" value="Enviar">
    </form>
    <?php
    if (isset($_POST["enviar"])){
        if ($error_input){
            echo "El valor introducido no es correcto";
        } else {
            if (isset($_POST["estado"]) && $_POST["estado"] == "estudiante" || $_POST["input"] < 12){
                $resultado = 3.5;
                echo "La entrada es: $resultado euros";
            } else if (isset($_POST["estado"]) && $_POST["estado"] == "otro" || $_POST["input"] > 12){
                $resultado = 5;
                echo "La entrada es: $resultado euros";
            } else {
                echo "No se ha seleccionado ninguna estado";
            }
        }
    }
    ?>
</body>
</html>
