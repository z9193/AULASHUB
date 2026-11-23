-- Catálogo de insumos. Presídium solo aplica a espacios tipo Auditorio.
-- No incluir sillas.

CREATE TABLE IF NOT EXISTS insumos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL UNIQUE,
    solo_auditorio TINYINT(1) NOT NULL DEFAULT 0,
    activo TINYINT(1) NOT NULL DEFAULT 1
);

INSERT INTO insumos (nombre, solo_auditorio, activo) VALUES
('Micrófono inalámbrico', 0, 1),
('Micrófono de solapa', 0, 1),
('Proyector / Cañón', 0, 1),
('Pantalla de proyección', 0, 1),
('Sistema de sonido', 0, 1),
('Laptop de respaldo', 0, 1),
('Pizarrón / marcadores', 0, 1),
('Presídium', 1, 1);
