CREATE DATABASE bd_cv;
USE bd_cv;
CREATE TABLE usuarios(
	id_usuario int PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(30),
    clave varchar(50),
    nombre varchar(50),
    dni varchar(10),
    sexo ENUM("hombre","mujer"),
    foto varchar(30) DEFAULT "no_imagen.jpg"
);