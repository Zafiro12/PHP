<?php
if (isset($_POST['guardar']) && $_POST['guardar'] == 'Guardar' && !empty($_POST['nombre']) && !empty($_POST['apellido'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recepción</title>
</head>
<body>
    <h1>Recepción de datos</h1>
    <?php
    echo "<p><strong>Nombre: </strong>$nombre</p>";
    echo "<p><strong>Apellido: </strong>$apellido</p>";
    ?>
</body>
<?php
} else {
    header('Location: index.php');
}
?>
</html>
