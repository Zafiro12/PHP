<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario</title>
</head>
<body>
<?php
$error_nombre = empty($_GET['nombre']);
$error_apellidos = empty($_GET['apellidos']);

if (isset($_GET["enviar"]) && !$error_nombre && !$error_apellidos) {
    echo "<h2>Datos recibidos:</h2>";
    echo "Nombre: " . $_GET['nombre'] . "<br>";
    echo "Apellidos: " . $_GET['apellidos'] . "<br>";
} else {
    ?>
    <form action="index.php" method="get">
        <label>Nombre:
            <input type="text" name="nombre" value="<?php if (isset($_GET["nombre"])) {
                echo $_GET["nombre"];
            } ?>"> <?php
            if ($error_nombre) {
                echo "<span style='color: red'>*Campo Obligatorio</span>";
            }
            ?>
        </label><br><br>
        <label>Apellidos:
            <input type="text" name="apellidos" value="<?php if (isset($_GET["apellidos"])) {
                echo $_GET["apellidos"];
            } ?>"> <?php
            if ($error_apellidos) {
                echo "<span style='color: red'>*Campo Obligatorio</span>";
            }
            ?>
        </label><br><br>
        <button type="submit" name="enviar">Enviar</button>
    </form>
    <?php
}
?>
</body>
</html>