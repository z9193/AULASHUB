-- Seed de usuarios de prueba — Facultad de Contaduría y Administración
-- Contraseña de todos: fca123

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(80) NOT NULL UNIQUE,
    password VARCHAR(120) NOT NULL,
    nombre VARCHAR(160) NOT NULL,
    rol ENUM('admin','consulta') NOT NULL,
    horario_inicio TIME NOT NULL,
    horario_fin TIME NOT NULL,
    facultad VARCHAR(160) NOT NULL,
    requisitos TEXT NOT NULL
);

INSERT INTO usuarios (usuario, password, nombre, rol, horario_inicio, horario_fin, facultad, requisitos) VALUES
('secretaria_matutino', 'fca123', 'Secretaria turno matutino', 'admin', '07:00:00', '14:00:00', 'Facultad de Contaduría y Administración', 'Identificación oficial; Oficio de comisión; Correo institucional activo'),
('secretaria_vespertino', 'fca123', 'Secretaria turno vespertino', 'admin', '14:00:00', '21:00:00', 'Facultad de Contaduría y Administración', 'Identificación oficial; Oficio de comisión; Correo institucional activo'),
('secretaria_2piso', 'fca123', 'Secretaria turno matutino 2do piso', 'admin', '07:00:00', '14:00:00', 'Facultad de Contaduría y Administración', 'Identificación oficial; Acceso a salas de 2do piso; Correo institucional activo'),
('coordinacion_virtual', 'fca123', 'Coordinación Modalidad Virtual', 'admin', '08:00:00', '18:00:00', 'Facultad de Contaduría y Administración', 'Cuenta de plataforma virtual; Oficio de coordinación; Correo institucional activo'),
('secretaria_academica', 'fca123', 'Secretaria académica', 'admin', '08:00:00', '16:00:00', 'Facultad de Contaduría y Administración', 'Identificación oficial; Nombramiento académico; Correo institucional activo'),
('maestro1', 'fca123', 'maestro 1', 'consulta', '08:00:00', '14:00:00', 'Facultad de Contaduría y Administración', 'Carga académica vigente; Solicitud de espacio; Correo institucional activo'),
('maestro2', 'fca123', 'maestro 2', 'consulta', '14:00:00', '20:00:00', 'Facultad de Contaduría y Administración', 'Carga académica vigente; Solicitud de espacio; Correo institucional activo');
