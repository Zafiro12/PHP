<?php

use Fruta as GlobalFruta;

class Fruta
{
    private $color;
    private $tamanyo;
    private static $nFrutas = 0;

    public function __construct($color = "", $tamanyo = "")
    {
        $this->color = $color;
        $this->tamanyo = $tamanyo;
        self::$nFrutas++;
    }

    public function __destruct()
    {
        self::$nFrutas--;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getTamanyo()
    {
        return $this->tamanyo;
    }

    public static function getNFrutas()
    {
        return self::$nFrutas;
    }

    public function setColor($colorNuevo)
    {
        $this->color = $colorNuevo;
    }

    public function setTamanyo($tamanyoNuevo)
    {
        $this->tamanyo = $tamanyoNuevo;
    }

    public function __toString()
    {
        return "
        <p><strong>Color: </strong>" . $this->color . "</p>
        <p><strong>Tamaño: </strong>" . $this->tamanyo . "</p>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fruta</title>
</head>

<body>
    <?php
    echo "<h1>Info de las frutas</h1>";

    $pera = new Fruta("Verde", "Mediano");
    $uva = new Fruta("Verde", "Pequeño");
    $manzana = new Fruta("Rojo", "Mediano");

    echo "<p><strong>Frutas creadas hasta ahora: </strong>".Fruta::getNFrutas()."</p>";
    $uva->__destruct();
    echo "<p><strong>Frutas creadas despues de destruir uva: </strong>".Fruta::getNFrutas()."</p>";
    ?>
</body>

</html>