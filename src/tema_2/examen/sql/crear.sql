CREATE DATABASE IF NOT EXISTS bd_exam_colegio;
USE bd_exam_colegio;

CREATE TABLE IF NOT EXISTS alumnos (
    cod_alu INT(11) NOT NULL,
    nombre VARCHAR(15) NOT NULL,
    telefono INT(11) NOT NULL,
    cod_postal INT(11) NOT NULL,
    PRIMARY KEY (cod_alu)
);

CREATE TABLE IF NOT EXISTS asignaturas (
    cod_asig INT(11) NOT NULL,
    denominacion TEXT NOT NULL,
    PRIMARY KEY (cod_asig)
);

CREATE TABLE IF NOT EXISTS notas (
    cod_asig INT(11) NOT NULL,
    cod_alu INT(11) NOT NULL,
    nota DECIMAL(4,2) NOT NULL,
    PRIMARY KEY (cod_asig, cod_alu),
    FOREIGN KEY (cod_asig) REFERENCES asignaturas(cod_asig) ON DELETE NO ACTION ON UPDATE CASCADE,
    FOREIGN KEY (cod_alu) REFERENCES alumnos(cod_alu) ON DELETE NO ACTION ON UPDATE CASCADE
);

INSERT INTO alumnos (cod_alu, nombre, telefono, cod_postal) VALUES
(1, 'Juan', 123456789, 12345),
(2, 'Ana', 987654321, 54321),
(3, 'Luis', 111111111, 11111),
(4, 'Maria', 222222222, 22222),
(5, 'Pedro', 333333333, 33333),
(6, 'Luisa', 444444444, 44444),
(7, 'Jose', 555555555, 55555),
(8, 'Antonio', 666666666, 66666),
(9, 'Rosa', 777777777, 77777),
(10, 'Marta', 888888888, 88888);

INSERT INTO asignaturas (cod_asig, denominacion) VALUES
(1, 'Matematicas'),
(2, 'Lengua'),
(3, 'Ingles'),
(4, 'Historia'),
(5, 'Geografia'),
(6, 'Fisica'),
(7, 'Quimica'),
(8, 'Biologia'),
(9, 'Economia'),
(10, 'Filosofia');