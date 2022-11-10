DROP DATABASE IF EXISTS bd_foro;
CREATE DATABASE IF NOT EXISTS bd_foro;

USE bd_foro;

CREATE TABLE usuarios (
  id_usuario int NOT NULL AUTO_INCREMENT,
  nombre varchar(20),
  usuario varchar(30),
  clave varchar(50),
  email varchar(50),
  PRIMARY KEY (id_usuario)
);

INSERT INTO usuarios (nombre, usuario, clave, email) VALUES
('admin', 'admin', 'admin', 'admin@localhost');
