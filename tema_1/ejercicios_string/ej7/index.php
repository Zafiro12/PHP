<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejercicio</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <!-- 
        Escribe un formulario que admita únicamente números enteros o decimales
separados por espacios en los que la separación entre la parte entera y la
decimal pueda ser con comas o con puntos, y que deje todos los números
con puntos.
    -->
    <form action="index.php" method="post">
        <label for="numero">Introduce un número:</label>
        <input type="text" name="numero" id="numero" required>
        <input type="submit" value="Convertir" name="submit">
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $numero = $_POST['numero'];
        $numero = str_replace(',', '.', $numero);
        echo "<p>El número corregido es: $numero</p>";
    }
    ?>
</body>

</html>