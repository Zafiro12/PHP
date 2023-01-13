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
        $sentencia = "
            SELECT 
                *
            FROM
                usuarios;
        ";

        try {
            $sentencia = $this->db->query($sentencia);
            $resultado = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        } catch (\PDOException $e) {
            pagina_error($e->getMessage());
        }
    }

    public function buscarId($id)
    {
        $sentencia = "
            SELECT 
                *
            FROM
                usuarios
            WHERE id = ?;
        ";

        try {
            $sentencia = $this->db->prepare($sentencia);
            $sentencia->execute(array($id));
            $resultado = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
            return $resultado;
        } catch (\PDOException $e) {
            pagina_error($e->getMessage());
        }
    }

    public function comprobar($usuario, $clave)
    {
        $sentencia = "
            SELECT 
                *
            FROM
                usuarios
            WHERE usuario = ? AND password = ?;
        ";

        try {
            $sentencia = $this->db->prepare($sentencia);
            $sentencia->execute(array($usuario, $clave));
            return $sentencia->rowCount()>0;
        } catch (\PDOException $e) {
            pagina_error($e->getMessage());
        }
    }

    public function insertar(array $input)
    {
        $sentencia = "
            INSERT INTO usuarios 
                (usuario, clave, nombre, email)
            VALUES
                (:usuario, :clave, :nombre, :email);
        ";

        try {
            $sentencia = $this->db->prepare($sentencia);
            $sentencia->execute(array(
                'usuario' => $input['usuario'],
                'clave'  => $input['clave'],
                'nombre' => $input['nombre'],
                'email' => $input['email'],
            ));
            return $sentencia->rowCount();
        } catch (\PDOException $e) {
            pagina_error($e->getMessage());
        }
    }

    public function cambiar($id, array $input)
    {
        $sentencia = "
            UPDATE usuarios
            SET 
                usuario = :usuario,
                clave  = :clave,
                nombre = :nombre,
                email = :email
            WHERE id = :id;
        ";

        try {
            $sentencia = $this->db->prepare($sentencia);
            $sentencia->execute(array(
                'id' => (int) $id,
                'usuario' => $input['usuario'],
                'clave'  => $input['clave'],
                'nombre' => $input['nombre'],
                'email' => $input['email'],
            ));
            return $sentencia->rowCount();
        } catch (\PDOException $e) {
            pagina_error($e->getMessage());
        }
    }

    public function eliminar($id)
    {
        $sentencia = "
            DELETE FROM usuarios
            WHERE id = :id;
        ";

        try {
            $sentencia = $this->db->prepare($sentencia);
            $sentencia->execute(array('id' => $id));
            return $sentencia->rowCount();
        } catch (\PDOException $e) {
            pagina_error($e->getMessage());
        }
    }
}
