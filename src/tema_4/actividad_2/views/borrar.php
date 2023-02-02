<?php
$cod = $_GET["borrar"];
if (isset($_GET["conf"])) {
    $borrar = json_decode(consumir_servicios_REST(URL . "producto/borrar/" . $cod, "DELETE"));
    if (!$borrar) {
        die("Error de conexión a los servicios.");
    } else {
        header("Location: index.php");
        exit();
    }
}

echo "<p>¿Estás seguro de querer borrar el producto con cod: $cod?</p>";
echo "<br>";
echo "<button>";
echo "<a style=\"text-decoration: none; color: black;\" href=\"index.php?borrar=$cod&conf=1\">Si</a>";
echo "</button>";
echo "<button>";
echo "<a style=\"text-decoration: none; color: black;\" href=\"index.php\">No</a>";
echo "</button>";
echo "<hr>";