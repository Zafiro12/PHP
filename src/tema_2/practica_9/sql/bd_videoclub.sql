CREATE DATABASE IF NOT EXISTS bd_videoclub;
USE bd_videoclub;
CREATE TABLE peliculas(
	id_pelicula int PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(15),
    director varchar(20),
    sinopsis text,
    tematica varchar(15),
    caratula varchar(30) DEFAULT "img/default.jpg"
);