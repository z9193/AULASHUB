-- Espacios FCA: 1 aula, 1 auditorio, 1 sala por piso
CREATE TABLE IF NOT EXISTS espacios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL UNIQUE,
    tipo ENUM('Aula','Auditorio','Sala de juntas') NOT NULL,
    piso VARCHAR(40) NOT NULL,
    estado ENUM('Disponible','Ocupada','Mantenimiento') NOT NULL DEFAULT 'Disponible',
    facultad VARCHAR(160) NOT NULL
);

INSERT INTO espacios (nombre, tipo, piso, estado, facultad) VALUES
('Aula Virtual', 'Aula', 'Virtual', 'Disponible', 'Facultad de Contaduría y Administración'),
('Auditorio', 'Auditorio', 'Planta baja', 'Disponible', 'Facultad de Contaduría y Administración'),
('Sala de juntas - 1er piso', 'Sala de juntas', 'Primer piso', 'Disponible', 'Facultad de Contaduría y Administración'),
('Sala de juntas - 2do piso', 'Sala de juntas', 'Segundo piso', 'Disponible', 'Facultad de Contaduría y Administración');
