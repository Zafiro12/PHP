<?php

class Usuarios
{

    private $db;

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
            return $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
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
            WHERE idUsuario = ?;
        ";

        try {
            $sentencia = $this->db->prepare($sentencia);
            $sentencia->execute(array($id));
            return $sentencia->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
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
            return $sentencia->rowCount() > 0;
        } catch (PDOException $e) {
            pagina_error($e->getMessage());
        }
    }

    public function insertar(array $input)
    {
        $sentencia = "
            INSERT INTO usuarios 
                (usuario, password, nombre, email)
            VALUES
                (:usuario, :clave, :nombre, :email);
        ";

        try {
            $sentencia = $this->db->prepare($sentencia);
            $sentencia->execute(array(
                'usuario' => $input['usuario'],
                'clave' => $input['clave'],
                'nombre' => $input['nombre'],
                'email' => $input['email'],
            ));
            return $sentencia->rowCount();
        } catch (PDOException $e) {
            pagina_error($e->getMessage());
        }
    }

    public function cambiar($id, array $input)
    {
        $sentencia = "
            UPDATE usuarios
            SET 
                usuario = :usuario,
                password  = :clave,
                nombre = :nombre,
                email = :email
            WHERE idUsuario = :id;
        ";

        try {
            $sentencia = $this->db->prepare($sentencia);
            $sentencia->execute(array(
                'id' => (int)$id,
                'usuario' => $input['usuario'],
                'clave' => $input['clave'],
                'nombre' => $input['nombre'],
                'email' => $input['email'],
            ));
            return $sentencia->rowCount();
        } catch (PDOException $e) {
            pagina_error($e->getMessage());
        }
    }

    public function eliminar($id)
    {
        $sentencia = "
            DELETE FROM usuarios
            WHERE idUsuario = :id;
        ";

        try {
            $sentencia = $this->db->prepare($sentencia);
            $sentencia->execute(array('id' => $id));
            return $sentencia->rowCount();
        } catch (PDOException $e) {
            pagina_error($e->getMessage());
        }
    }
}
