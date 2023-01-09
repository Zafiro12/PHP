<?php
class Empleado
{
    private $enlaces = [];

    public function getEnlaces()
    {
        return $this->enlaces;
    }

    public function addEnlace($nombre, $url)
    {
        $this->enlaces = array_merge($this->enlaces, [$nombre,$url]);
    }

    public function imprimirH()
    {
        return;
    }

    public function imprimirv()
    {
        return;
    }
}
