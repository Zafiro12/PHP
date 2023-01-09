<?php
class Fruta
{
    private $color;
    private $tamanyo;

    public function __construct($color = "", $tamanyo = "")
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

    public function __toString()
    {
        return "<h1>Info de la fruta</h1>
        <p><strong>Color: </strong>" . $this->color . "</p>
        <p><strong>Tamaño: </strong>" . $this->tamanyo . "</p>";
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

    echo $pera->__toString();
    ?>
</body>

</html>