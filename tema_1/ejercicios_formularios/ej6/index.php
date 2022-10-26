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
        <input type="submit" name="enviar" value="Enviar">
    </form>
    <?php
    if (isset($_POST["enviar"])){
        if ($error_input){
            echo "El valor introducido no es correcto";
        } else {
            echo "Son " . $_POST["input"] * 166.386 . " pesetas";
        }
    }
    ?>
</body>
</html>
