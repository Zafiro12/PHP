<?php
if (isset($_POST['Guardar'])) {
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos</title>
</head>
<body>
<h1>Datos recibidos</h1>
<?php
    echo "<p><strong>Nombre: </strong>" . $_POST['nombre'] . "</p>";
    echo "<p><strong>Apellidos: </strong>" . $_POST['apellidos'] . "</p>";
    echo "<p><strong>Contraseña: </strong>" . $_POST['pwd'] . "</p>";
    echo "<p><strong>DNI: </strong>" . $_POST['nif'] . "</p>";
    if (isset($_POST['sexo'])) {
        echo "<p><strong>Sexo: </strong>" . $_POST['sexo'] . "</p>";
    }
    echo "<p><strong>Nacido en: </strong>" . $_POST['nacido'] . "</p>";
    echo "<p><strong>Comentarios: </strong>" . $_POST['comentarios'] . "</p>";
    if (isset($_POST['sub'])) {
        echo "<p><strong>Subscripción: </strong>Si</p>";
    } else {
        echo "<p><strong>Subscripción: </strong>No</p>";
    }
    ?>
</body>
</html>
<?php
}
else {
    header("Location: funciones.php");
}
?>