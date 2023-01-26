<?php
    session_start();
    if (isset($_POST['nombre']) && $_POST['nombre'] != "") {
        $_SESSION['nombre'] = $_POST['nombre'];
        echo "<p>Nombre: <strong>" . $_SESSION['nombre'] . "</strong></p>";
        echo "<p><a href='funciones.php'>Volver</a></p>";
    } else {
        echo "<p>No se ha introducido ningún nombre.</p>";
        echo "<p><a href='funciones.php'>Volver</a></p>";
    }
    