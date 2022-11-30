CREATE DATABASE IF NOT EXISTS bd_pract_exam2;
USE bd_pract_exam2;
/*BD con 3 tablas, departamento, trabaja_en, empleado*/
DROP TABLE IF EXISTS departamento;
DROP TABLE IF EXISTS trabaja_en;
DROP TABLE IF EXISTS empleado;
CREATE TABLE departamento(
    id_dep INT NOT NULL,
    nombre_dep VARCHAR(50) NOT NULL,
    planta INT NOT NULL,
    puerta INT NOT NULL,
    PRIMARY KEY(id_dep)
);
CREATE TABLE empleado(
    dni VARCHAR(9) NOT NULL,
    nombre_emp VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    PRIMARY KEY(dni)
);
CREATE TABLE trabaja_en(
    dni VARCHAR(9) NOT NULL,
    id_dep INT NOT NULL,
    PRIMARY KEY(dni, id_dep),
    FOREIGN KEY (dni) REFERENCES empleado(dni) ON DELETE NO ACTION ON UPDATE CASCADE,
    FOREIGN KEY (id_dep) REFERENCES departamento(id_dep) ON DELETE NO ACTION ON UPDATE CASCADE
);

INSERT INTO departamento(id_dep, nombre_dep, planta, puerta) VALUES
(1, 'Informatica', 1, 1),
(2, 'Recursos Humanos', 2, 2),
(3, 'Ventas', 3, 3),
(4, 'Compras', 4, 4),
(5, 'Marketing', 5, 5),
(6, 'Contabilidad', 6, 6),
(7, 'Administracion', 7, 7),
(8, 'Produccion', 8, 8),
(9, 'Logistica', 9, 9),
(10, 'Mantenimiento', 10, 10);

INSERT INTO empleado(dni, nombre_emp, email) VALUES
('12345678A', 'Juan Perez', 'juan@a.es'),
('23456789B', 'Maria Lopez', 'maria@b.es'),
('34567890C', 'Pedro Gomez', 'pedro@c.es');

INSERT INTO trabaja_en(dni, id_dep) VALUES
('12345678A', 1),
('12345678A', 2),
('12345678A', 3),
('23456789B', 2),
('23456789B', 3),
('23456789B', 4),
('23456789B', 5),
('34567890C', 3),
('34567890C', 4),
('34567890C', 5);

/*Empleados que trabajan en el dep 3*/
SELECT * FROM empleado WHERE dni IN (SELECT dni FROM trabaja_en WHERE id_dep = 3);
/*Departamentos en los que trabaja Juan Perez*/
SELECT * FROM departamento WHERE id_dep IN (SELECT id_dep FROM trabaja_en WHERE dni = '12345678A');