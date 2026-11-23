<?php

class Reserva
{
    public function obtenerReservas(): array
    {
        return [
            [
                "id" => 1,
                "responsable" => "maestro 1",
                "espacio" => "Aula Virtual",
                "fecha" => "2026-11-22",
                "hora_inicio" => "08:00",
                "hora_fin" => "10:00",
                "actividad" => "Clase de Contabilidad I",
                "estado" => "En curso",
                "insumos" => ["Proyector / Cañón", "Laptop de respaldo"],
                "facultad" => "Facultad de Contaduría y Administración",
            ],
            [
                "id" => 2,
                "responsable" => "Secretaria académica",
                "espacio" => "Sala de juntas - 1er piso",
                "fecha" => "2026-11-22",
                "hora_inicio" => "10:00",
                "hora_fin" => "12:00",
                "actividad" => "Junta de academia",
                "estado" => "Confirmada",
                "insumos" => ["Pizarrón / marcadores"],
                "facultad" => "Facultad de Contaduría y Administración",
            ],
            [
                "id" => 3,
                "responsable" => "Coordinación Modalidad Virtual",
                "espacio" => "Auditorio",
                "fecha" => "2026-11-24",
                "hora_inicio" => "16:00",
                "hora_fin" => "18:00",
                "actividad" => "Inducción a modalidad virtual",
                "estado" => "Pendiente",
                "insumos" => ["Micrófono inalámbrico", "Sistema de sonido", "Pantalla de proyección", "Presídium"],
                "facultad" => "Facultad de Contaduría y Administración",
            ],
            [
                "id" => 4,
                "responsable" => "maestro 2",
                "espacio" => "Sala de juntas - 2do piso",
                "fecha" => "2026-11-22",
                "hora_inicio" => "14:00",
                "hora_fin" => "16:00",
                "actividad" => "Asesoría de tesis",
                "estado" => "Confirmada",
                "insumos" => ["Laptop de respaldo"],
                "facultad" => "Facultad de Contaduría y Administración",
            ],
            [
                "id" => 5,
                "responsable" => "Secretaria turno vespertino",
                "espacio" => "Sala de juntas - 2do piso",
                "fecha" => "2026-11-25",
                "hora_inicio" => "18:00",
                "hora_fin" => "20:00",
                "actividad" => "Reunión de coordinación vespertina",
                "estado" => "Confirmada",
                "insumos" => ["Micrófono de solapa"],
                "facultad" => "Facultad de Contaduría y Administración",
            ],
            [
                "id" => 6,
                "responsable" => "Secretaria turno matutino 2do piso",
                "espacio" => "Sala de juntas - 1er piso",
                "fecha" => "2026-11-26",
                "hora_inicio" => "09:00",
                "hora_fin" => "11:00",
                "actividad" => "Entrega de actas",
                "estado" => "Cancelada",
                "insumos" => [],
                "facultad" => "Facultad de Contaduría y Administración",
            ],
        ];
    }
}
