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
        <label>Introduce los euros a convertir:
            <input type="text" name="input">
        </label>
        <label>
            <input type="radio" name="moneda" id="dolares" value="dolares">Dólares
        </label>
        <label>
            <input type="radio" name="moneda" id="pesetas" value="pesetas">Pesetas
        </label>
        <input type="submit" name="enviar" value="Enviar">
    </form>
    <?php
    if (isset($_POST["enviar"])){
        if ($error_input){
            echo "El valor introducido no es correcto";
        } else {
            // Conversión según la moneda seleccionada mediante el radio moneda
            if (isset($_POST["moneda"]) && $_POST["moneda"] == "dolares"){
                $resultado = $_POST["input"] * 1.12;
                echo "El resultado de la conversión es: $resultado";
            } else if (isset($_POST["moneda"]) && $_POST["moneda"] == "pesetas"){
                $resultado = $_POST["input"] * 166.386;
                echo "El resultado de la conversión es: $resultado";
            } else {
                echo "No se ha seleccionado ninguna moneda";
            }
        }
    }
    ?>
</body>
</html>
