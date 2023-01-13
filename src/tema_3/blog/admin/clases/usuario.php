<?php
class Usuarios
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function todos()
    {
        $statement = "
            SELECT 
                *
            FROM
                usuarios;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function buscarId($id)
    {
        $statement = "
            SELECT 
                *
            FROM
                usuarios
            WHERE id = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function buscarUsuario($usuario)
    {
        $statement = "
            SELECT 
                *
            FROM
                usuarios
            WHERE usuario = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($usuario));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insertar(array $input)
    {
        $statement = "
            INSERT INTO usuarios 
                (usuario, clave, nombre, email)
            VALUES
                (:usuario, :clave, :nombre, :email);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'usuario' => $input['usuario'],
                'clave'  => $input['clave'],
                'nombre' => $input['nombre'],
                'email' => $input['email'],
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function cambiar($id, array $input)
    {
        $statement = "
            UPDATE usuarios
            SET 
                usuario = :usuario,
                clave  = :clave,
                nombre = :nombre,
                email = :email
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'usuario' => $input['usuario'],
                'clave'  => $input['clave'],
                'nombre' => $input['nombre'],
                'email' => $input['email'],
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function eliminar($id)
    {
        $statement = "
            DELETE FROM usuarios
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
