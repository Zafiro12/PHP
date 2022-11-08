CREATE DATABASE IF NOT EXISTS bd_foro;
USE bd_foro;
CREATE TABLE usuarios (
  id_usuario int(11) NOT NULL,
  usuario varchar(30),
  nombre varchar(20),
  clave varchar(50),
  email varchar(50),
  PRIMARY KEY (id_usuario)
);

INSERT INTO usuarios (id_usuario, usuario, nombre, clave, email) VALUES
(1, 'admin', 'Administrador', '21232f297a57a5a743894a0e4a801fc3', 'admin@localhost'),
(2, 'usuario', 'Usuario', 'ee11cbb19052e40b07aac0ca060c23ee', 'usuario@localhost');
