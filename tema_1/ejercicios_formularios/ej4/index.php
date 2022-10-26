<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario</title>
    <style>
        body {
            display: block;
        }
    </style>
</head>

<body>
<?php
$error_n1 = empty($_POST['n1']) || !is_numeric($_POST['n1']);
$error_n2 = empty($_POST['n2']) || !is_numeric($_POST['n2']);

if (isset($_POST["enviar"]) && !$error_n1 && !$error_n2) {
    $n1 = $_POST['n1'];
    $n2 = $_POST['n2'];
    echo "<h2>Datos recibidos:</h2>";
    echo "Suma: " . $n1 + $n2 . "<br>";
    echo "Resta: " . $n1 - $n2 . "<br>";
    echo "Multiplicación: " . $n1 * $n2 . "<br>";
    echo "División: " . $n1 / $n2 . "<br>";
    echo "Módulo: " . $n1 % $n2 . "<br>";
} else {
    ?>
    <form action="index.php" method="post">
        <label>1er número:
            <input type="text" name="n1" value="<?php if (isset($_POST["n1"])) {
                echo $_POST["n1"];
            } ?>"> <?php
            if ($error_n1) {
                echo "<span style='color: red'>*Campo Obligatorio</span>";
            }
            ?>
        </label><br><br>
        <label>2o número:
            <input type="text" name="n2" value="<?php if (isset($_POST["n2"])) {
                echo $_POST["n2"];
            } ?>"> <?php
            if ($error_n2) {
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