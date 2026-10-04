<?php

class Aula
{
    public function obtenerAulas(): array
    {
        return [
            ["id" => 1, "nombre" => "Aula Virtual", "tipo" => "Aula Virtual", "estado" => "Disponible"],
            ["id" => 2, "nombre" => "Auditorio", "tipo" => "Auditorio", "estado" => "Disponible"],
        ];
    }

    public function obtenerHorarios(): array
    {
        return ["08:00 - 10:00", "10:00 - 12:00", "12:00 - 14:00", "14:00 - 16:00", "16:00 - 18:00", "18:00 - 20:00"];
    }

    public function obtenerInsumos(): array
    {
        return [
            "Micrófono inalámbrico",
            "Micrófono de solapa",
            "Proyector / Cañón",
            "Pantalla de proyección",
            "Presídium",
            "Sistema de sonido",
            "Laptop de respaldo",
            "Sillas adicionales",
        ];
    }

    public function obtenerHorarioOperativo(): array
    {
        return [
            "labora" => ["inicio" => "08:00", "fin" => "20:00"],
            "sabado" => ["inicio" => "09:00", "fin" => "12:00"],
        ];
    }
}
