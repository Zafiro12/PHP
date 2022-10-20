<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario</title>
</head>
<body>
<?php
$error_nombre = empty($_POST['nombre']);
$error_apellido = empty($_POST['apellido']);
$error_calle = empty($_POST['calle']);
$error_cp = empty($_POST['cp']);
$error_localidad = empty($_POST['localidad']);

?>
<form action="index.php" method="post">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre"><?php if ($error_nombre) echo "El nombre es obligatorio"; ?><br>
    <label for="apellido">Apellido</label>
    <input type="text" name="apellido" id="apellido"><?php if ($error_apellido) echo "El apellido es obligatorio"; ?><br>
    <label for="calle">Calle</label>
    <input type="text" name="calle" id="calle"><?php if ($error_calle) echo "La calle es obligatoria"; ?><br>
    <label for="cp">Código Postal</label>
    <input type="text" name="cp" id="cp"><?php if ($error_cp) echo "El código postal es obligatorio"; ?><br>
    <label for="localidad">Localidad</label>
    <input type="text" name="localidad" id="localidad"><?php if ($error_localidad) echo "La localidad es obligatoria"; ?><br>
    <input type="submit" name="enviar" value="Enviar">
</form>
<?php
if (isset($_POST['enviar'])) {
    if (!$error_nombre && !$error_apellido && !$error_calle && !$error_cp && !$error_localidad) {
        echo "<hr>";
        echo "<h1>Datos del formulario</h1>";
        echo "Nombre: " . $_POST['nombre'] . "<br>";
        echo "Apellido: " . $_POST['apellido'] . "<br>";
        echo "Calle: " . $_POST['calle'] . "<br>";
        echo "Código Postal: " . $_POST['cp'] . "<br>";
        echo "Localidad: " . $_POST['localidad'] . "<br>";
    }
}
?>
</body>
</html>