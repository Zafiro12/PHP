<?php
if (isset($_POST['rellenar'])) {
    $sql = "INSERT INTO usuarios (nombre, usuario, clave, email) VALUES ";

    $max = 1000;

    for ($i = 1; $i <= $max; $i++) {
        if ($i == $max) {
            $sql .= "('Usuario $i', 'usuario$i', 'clave$i', 'usuario$i@usuario$i.com');";
            break;
        }
        $sql .= "('Usuario $i', 'usuario$i', 'clave$i', 'usuario$i@usuario$i.com'),";
    }

    if (!mysqli_query($conexion, $sql)) {
        echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . mysqli_error($conexion) . "</p>";
        exit;
    }
}