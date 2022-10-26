<?php
$refresco = $_POST['refrescos'];
$numero = 1;

if (!empty($_POST["numero"])) {
    $numero = abs($_POST["numero"]);
}

$precio = 0;

switch ($refresco) {
    case "Coca Cola":
        $precio = 1;
        break;
    case "Pepsi":
        $precio = 0.8;
        break;
    case "Fanta":
        $precio = 0.9;
        break;
    case "Trina":
        $precio = 1.2;
        break;
}

$precio_total = $precio * $numero;

echo "<h1>Pago</h1>";
echo "<p>Has pedido $numero $refresco a $precio € cada uno.</p>";
echo "<p>El precio total es $precio_total €.</p>";
