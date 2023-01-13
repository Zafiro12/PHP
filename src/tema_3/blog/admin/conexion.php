<?php
require_once "config.php";


class Conexion
{
    private $dbConnection = null;

    public function __construct($host, $db, $user, $password)
    {
        try {
            $this->dbConnection = new \PDO("mysql:host=$host;charset=utf8mb4;dbname=$db", $user, $password);
        } catch (\PDOException $e) {
            pagina_error($e->getMessage());
        }
    }

    public function conectar()
    {
        return $this->dbConnection;
    }
}
