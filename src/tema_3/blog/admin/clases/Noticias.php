<?php

class Noticias
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
                noticias;
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
                noticias
            WHERE idNoticia = ?;
        ";

        try {
            $sentencia = $this->db->prepare($sentencia);
            $sentencia->execute(array($id));
            return $sentencia->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            pagina_error($e->getMessage());
        }
    }

    public function insertar(array $input)
    {
        $sentencia = "
            INSERT INTO noticias 
                (titulo, copete, cuerpo, idUsuario, idCategoria, fPublicacion)
            VALUES
                (:titulo, :copete, :cuerpo, :idUsuario, :idCategoria, :fPublicacion);
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

    public function eliminar($id)
    {
        $sentencia = "
            DELETE FROM noticias
            WHERE idNoticia = :id;
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