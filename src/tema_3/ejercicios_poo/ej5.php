<?php
class Empleado
{
    private $nombre;
    private $sueldo;

    public function __construct($nombre=null, $sueldo=null)
    {
        $this->nombre = $nombre;
        $this->sueldo = $sueldo;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getSueldo()
    {
        return $this->sueldo;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setSueldo($sueldo)
    {
        $this->nombre = $sueldo;
    }

    public function stringImpuestos()
    {
        if ($this->sueldo > 3000) {
            return "<p><strong>".$this->nombre.": </strong>debe de pagar impuestos</p>";
        }
        return "<p><strong>".$this->nombre.": </strong>no debe de pagar impuestos</p>";
    }
}
