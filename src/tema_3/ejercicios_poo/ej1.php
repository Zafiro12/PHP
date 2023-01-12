<?php
class Fruta
{
    private $color;
    private $tamanyo;

    public function __construct($color="", $tamanyo="")
    {
        $this->color = $color;
        $this->tamanyo = $tamanyo;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getTamanyo()
    {
        return $this->tamanyo;
    }

    public function setColor($colorNuevo)
    {
        $this->color = $colorNuevo;
    }

    public function setTamanyo($tamanyoNuevo)
    {
        $this->tamanyo = $tamanyoNuevo;
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
        $pera = new Fruta("Verde", "Mediano");

        echo "<h1>Info de la fruta</h1>";
        echo "<p><strong>Color: </strong>".$pera->getColor()."</p>";
        echo "<p><strong>Tamaño: </strong>".$pera->getTamanyo()."</p>";
    ?>
</body>
</html>
