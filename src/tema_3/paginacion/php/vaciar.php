<?php
if (isset($_POST['vaciar'])) {
    $sql = "DELETE FROM usuarios";

    if (!mysqli_query($conexion, $sql)) {
        echo "<p>Error al ejecutar la sentencia <b>$sql</b>: " . mysqli_error($conexion) . "</p>";
        exit;
    }
}