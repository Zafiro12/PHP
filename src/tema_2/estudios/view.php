<?php
function seleccionar($link, $tabla, $id)
{
    $sql = "SELECT * FROM $tabla WHERE id = $id";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            mysqli_free_result($result);
            return $row;
        } else {
            mysqli_free_result($result);
            return false;
        }
    } else {
        return false;
    }
}

function verSeleccionado($link, $tabla, $id)
{
    $row = seleccionar($link, $tabla, $id);
    if ($row) {
        echo "<table>";
        foreach ($row as $key => $value) {
            echo "<tr><td>$key</td><td>$value</td></tr>";
        }
        echo "</table>";
        return true;
    } else {
        return false;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ver usuario</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <div class="centrar">
        <h1>Ver usuario</h1>
        <?php
        // Incluir archivo de configuracion
        require_once "config.php";

        if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
            $id = $_GET['id'];
            verSeleccionado($link, "usuarios", $id);
        } else {
            echo "Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
        }

        ?>
        <button type="button" onclick="window.location.href='index.php'">Volver</button>
    </div>

</body>

</html>