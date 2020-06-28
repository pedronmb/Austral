CREATE DATABASE IF NOT EXISTS austral_db;
USE austral_db;

CREATE TABLE IF NOT EXISTS turnos(
id          int(255) auto_increment not null,
id_cola     int(255),
estado      boolean,
numero      int(255),
CONSTRAINT pk_turnos PRIMARY KEY(id)
)ENGINE=InnoDb;

INSERT INTO turnos (id_cola, estado, numero)
VALUES (1, false, 1);
INSERT INTO turnos (id_cola, estado, numero)
VALUES (2, false, 1);
INSERT INTO turnos (id_cola, estado, numero)
VALUES (3, false, 1);
INSERT INTO turnos (id_cola, estado, numero)
VALUES (4, false, 1);