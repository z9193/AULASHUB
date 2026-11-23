<?php

class Aula
{
    public function obtenerAulas(): array
    {
        return [
            ["id" => 1, "nombre" => "Aula Virtual", "tipo" => "Aula", "piso" => "Virtual", "estado" => "Disponible", "facultad" => "Facultad de Contaduría y Administración"],
            ["id" => 2, "nombre" => "Auditorio", "tipo" => "Auditorio", "piso" => "Planta baja", "estado" => "Disponible", "facultad" => "Facultad de Contaduría y Administración"],
            ["id" => 3, "nombre" => "Sala de juntas - 1er piso", "tipo" => "Sala de juntas", "piso" => "Primer piso", "estado" => "Disponible", "facultad" => "Facultad de Contaduría y Administración"],
            ["id" => 4, "nombre" => "Sala de juntas - 2do piso", "tipo" => "Sala de juntas", "piso" => "Segundo piso", "estado" => "Disponible", "facultad" => "Facultad de Contaduría y Administración"],
        ];
    }

    public function obtenerHoras(): array
    {
        $horas = [];
        for ($h = 7; $h <= 21; $h++) {
            $horas[] = sprintf('%02d:00', $h);
            if ($h < 21) {
                $horas[] = sprintf('%02d:30', $h);
            }
        }
        return $horas;
    }

    public function obtenerInsumos(): array
    {
        return [
            "Micrófono inalámbrico",
            "Micrófono de solapa",
            "Proyector / Cañón",
            "Pantalla de proyección",
            "Sistema de sonido",
            "Laptop de respaldo",
            "Pizarrón / marcadores",
            "Presídium",
        ];
    }

    public function obtenerHorarioOperativo(): array
    {
        return [
            "labora" => ["inicio" => "07:00", "fin" => "21:00"],
            "sabado" => ["inicio" => "09:00", "fin" => "13:00"],
        ];
    }

    public function obtenerFacultad(): string
    {
        return "Facultad de Contaduría y Administración";
    }
}
