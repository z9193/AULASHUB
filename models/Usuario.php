<?php

class Usuario
{
    public function obtenerUsuarios(): array
    {
        return [
            [
                "id" => 1,
                "usuario" => "secretaria_matutino",
                "password" => "fca123",
                "nombre" => "Secretaria turno matutino",
                "rol" => "admin",
                "horario_inicio" => "07:00",
                "horario_fin" => "14:00",
                "facultad" => "Facultad de Contaduría y Administración",
                "requisitos" => ["Identificación oficial", "Oficio de comisión", "Correo institucional activo"],
            ],
            [
                "id" => 2,
                "usuario" => "secretaria_vespertino",
                "password" => "fca123",
                "nombre" => "Secretaria turno vespertino",
                "rol" => "admin",
                "horario_inicio" => "14:00",
                "horario_fin" => "21:00",
                "facultad" => "Facultad de Contaduría y Administración",
                "requisitos" => ["Identificación oficial", "Oficio de comisión", "Correo institucional activo"],
            ],
            [
                "id" => 3,
                "usuario" => "secretaria_2piso",
                "password" => "fca123",
                "nombre" => "Secretaria turno matutino 2do piso",
                "rol" => "admin",
                "horario_inicio" => "07:00",
                "horario_fin" => "14:00",
                "facultad" => "Facultad de Contaduría y Administración",
                "requisitos" => ["Identificación oficial", "Acceso a salas de 2do piso", "Correo institucional activo"],
            ],
            [
                "id" => 4,
                "usuario" => "coordinacion_virtual",
                "password" => "fca123",
                "nombre" => "Coordinación Modalidad Virtual",
                "rol" => "admin",
                "horario_inicio" => "08:00",
                "horario_fin" => "18:00",
                "facultad" => "Facultad de Contaduría y Administración",
                "requisitos" => ["Cuenta de plataforma virtual", "Oficio de coordinación", "Correo institucional activo"],
            ],
            [
                "id" => 5,
                "usuario" => "secretaria_academica",
                "password" => "fca123",
                "nombre" => "Secretaria académica",
                "rol" => "admin",
                "horario_inicio" => "08:00",
                "horario_fin" => "16:00",
                "facultad" => "Facultad de Contaduría y Administración",
                "requisitos" => ["Identificación oficial", "Nombramiento académico", "Correo institucional activo"],
            ],
            [
                "id" => 6,
                "usuario" => "maestro1",
                "password" => "fca123",
                "nombre" => "maestro 1",
                "rol" => "consulta",
                "horario_inicio" => "08:00",
                "horario_fin" => "14:00",
                "facultad" => "Facultad de Contaduría y Administración",
                "requisitos" => ["Carga académica vigente", "Solicitud de espacio", "Correo institucional activo"],
            ],
            [
                "id" => 7,
                "usuario" => "maestro2",
                "password" => "fca123",
                "nombre" => "maestro 2",
                "rol" => "consulta",
                "horario_inicio" => "14:00",
                "horario_fin" => "20:00",
                "facultad" => "Facultad de Contaduría y Administración",
                "requisitos" => ["Carga académica vigente", "Solicitud de espacio", "Correo institucional activo"],
            ],
        ];
    }

    public function autenticar(string $usuario, string $password): ?array
    {
        foreach ($this->obtenerUsuarios() as $registro) {
            if ($registro['usuario'] === $usuario && $registro['password'] === $password) {
                return $registro;
            }
        }
        return null;
    }
}
