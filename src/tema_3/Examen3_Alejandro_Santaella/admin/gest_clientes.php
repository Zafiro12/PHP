<?php
if (isset($_GET["accion"])) {
    if ($_GET["accion"] == "eliminar") {
        $consulta = "DELETE FROM clientes WHERE id_cliente = ?";
        ejecutar_consulta($consulta, array($_GET["id"]));
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Examen3</title>
</head>
<body>
<h1>Video club</h1>
<?php
echo "<h2>Bienvenido " . $_SESSION["usuario"] . " - <a href='index.php?salir=1'>Salir</a></h2>";
?>
<h3>Tabla de clientes</h3>
<table border="1">
    <tr>
        <th>Usuario</th>
        <th>Foto</th>
        <th>Acciones</th>
    </tr>
    <?php
    $consulta = "select * from clientes";
    $resultado = ejecutar_consulta($consulta);
    while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
        if ($fila["tipo"] == "normal") {
            echo "<tr>";
            echo "<td>" . $fila["usuario"] . "</td>";
            echo "<td><img src='Images/" . $fila["foto"] . "' width='100px'></td>";
            echo "<td><a href='index.php?accion=modificar&id=" . $fila["id_cliente"] . "'>Modificar</a> - <a href='index.php?accion=eliminar&id=" . $fila["id_cliente"] . "'>Eliminar</a></td>";
            echo "</tr>";
        }
    }

    if (isset($_GET["accion"])) {
        if ($_GET["accion"] == "modificar") {
            $consulta = "select * from clientes where id=?";
            $resultado = ejecutar_consulta($consulta, array($_GET["id"]))->fetch(PDO::FETCH_ASSOC);
            echo "Modificar";
        }
    }
    ?>
</body>
</html>