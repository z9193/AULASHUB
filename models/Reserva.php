<?php

class Reserva
{
    public function obtenerReservas(): array
    {
        return [
            [
                "id" => 1,
                "responsable" => "Dra. Laura Méndez",
                "espacio" => "Auditorio",
                "fecha" => "2026-10-03",
                "hora" => "10:00 - 12:00",
                "estado" => "Completada",
                "insumos" => ["Micrófono inalámbrico", "Sistema de sonido", "Presídium"],
            ],
            [
                "id" => 2,
                "responsable" => "Ing. Carlos Ruiz",
                "espacio" => "Aula Virtual",
                "fecha" => "2026-10-04",
                "hora" => "08:00 - 10:00",
                "estado" => "Confirmada",
                "insumos" => ["Proyector / Cañón", "Laptop de respaldo"],
            ],
            [
                "id" => 3,
                "responsable" => "Mtra. Sofía Herrera",
                "espacio" => "Aula Virtual",
                "fecha" => "2026-10-04",
                "hora" => "14:00 - 16:00",
                "estado" => "En curso",
                "insumos" => ["Pantalla de proyección"],
            ],
            [
                "id" => 4,
                "responsable" => "Lic. Andrés Pineda",
                "espacio" => "Aula Virtual",
                "fecha" => "2026-10-06",
                "hora" => "16:00 - 18:00",
                "estado" => "Pendiente",
                "insumos" => [],
            ],
            [
                "id" => 5,
                "responsable" => "Área de Cultura",
                "espacio" => "Auditorio",
                "fecha" => "2026-10-07",
                "hora" => "18:00 - 20:00",
                "estado" => "Cancelada",
                "insumos" => ["Micrófono de solapa", "Sillas adicionales"],
            ],
        ];
    }
}
