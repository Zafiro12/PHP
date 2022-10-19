<?php
$cuadernos = $_POST['cuadernos'];

if ($cuadernos < 10) {
    $cuadernos = $cuadernos * 2;
} elseif ($cuadernos >= 10 && $cuadernos < 30) {
    $cuadernos = $cuadernos * 1.5;
} else {
    $cuadernos = $cuadernos * 1;
}

echo "El precio total es de $cuadernos €";