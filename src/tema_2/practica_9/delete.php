<?php
function eliminar($link, $tabla, $id)
{
    $sql = "SELECT foto FROM $tabla WHERE id_pelicula = $id";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            if ($row['caratula'] != "img/default.png") {
                unlink($row['foto']);
            }
        }
    }
    
    $sql = "DELETE FROM $tabla WHERE id_pelicula = $id";
    if (mysqli_query($link, $sql)) {
        return true;
    } else {
        return false;
    }
}
if (isset($_POST['id']) && !empty(trim($_POST['id']))) {
    // Incluir archivo de configuracion
    require_once "sql/config.php";
    $id = $_POST['id'];
    if (eliminar($link, "peliculas", $id)) {
        header("location: index.php");
        exit();
    } else {
        echo "Algo salió mal. Por favor, inténtelo de nuevo más tarde.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Eliminar pelicula</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>
    <div class="centrar">
        <h1>Eliminar pelicula <?php echo trim($_GET["id"]).PHP_EOL; ?> ?</h1>
        <form action="delete.php" method="post">
            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>" />
            <h3>Estás seguro de que quieres eliminar este registro?</h3>
            <div class="centrar">
                <div>
                    <input type="submit" value="Si" class="boton">
                    <button type="button" onclick="window.location.href='index.php'">No</button>
                </div>
            </div>
        </form>
    </div>

</body>

</html>