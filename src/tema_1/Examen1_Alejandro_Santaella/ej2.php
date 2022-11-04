<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Ejercicio 2</title>
</head>

<body>
    <?php
        $contar = isset($_POST["contar"]);
        $error_input = false;
        
        if ($contar) {
            $error_input = empty($_POST["input"]);
        }
    ?>
    <h1>Ejercicio 2. Longitud de las palabra extraídas</h1>
<form action="ej2.php" method="post">
    <label for="input">Introduzca un texto: </label>
    <input type="text" name="input" id="input" <?php 
        if ($contar && !$error_input) {
            echo "value='". $_POST["input"]."'";
        }
    ?>> <?php
        if ($contar && $error_input) {
            echo "*Campo obligatorio";
        }
    ?>
    <br><br>
    <label for="separador">Elija el separador</label>
    <select name="separador" id="">
        <option value=",">Coma</option>
        <option value=";">Punto y coma</option>
        <option value=":">Dos puntos</option>
    </select>
    <br><br>
    <input type="submit" name="contar" value="Contar">
</form>
<?php
    if($contar && !$error_input) {
        echo "<h2>Respuesta</h2>";
        $input = $_POST["input"];
        $separador = $_POST["separador"];

        $resultado = "";
        for ($i=0; $i <= strlen($input); $i++) { 
            if (@$input[$i] == $separador || $i  == strlen($input)) {
                echo "<p>" . $resultado . "(". strlen($resultado) .")". "</p>";
                $resultado = "";
                continue;
            } else {
                $resultado .= $input[$i];
            }
        }
    }
?>
</body>
</html>