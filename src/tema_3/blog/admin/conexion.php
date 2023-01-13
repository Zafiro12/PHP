<?php
require_once "config.php";


class Conexion
{
    private $dbConnection = null;

    public function __construct()
    {
        $host = HOST;
        $db   = DB;
        $user = USER;
        $pass = PASSWORD;

        try {
            $this->dbConnection = new \PDO(
                "mysql:host=$host;charset=utf8mb4;dbname=$db",
                $user,
                $pass
            );
        } catch (\PDOException $e) {
            pagina_error($e->getMessage());
        }
    }

    public function Conectar()
    {
        return $this->dbConnection;
    }
}
