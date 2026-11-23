<?php
function estadoBadgeClass($estado) {
    switch ($estado) {
        case "Disponible":
        case "Confirmada":
        case "Completada":
            return "bg-emerald-900/60 text-emerald-300 border border-emerald-500/50 font-bold";
        case "Ocupada":
        case "Cancelada":
            return "bg-red-900/60 text-red-300 border border-red-500/50 font-bold";
        case "Mantenimiento":
        case "Pendiente":
            return "bg-amber-900/60 text-amber-300 border border-amber-500/50 font-bold";
        case "En curso":
        default:
            return "bg-[#7A1A2E] text-white border border-[#7A1A2E] font-bold";
    }
}

function horarioReserva(array $reserva): string
{
    if (!empty($reserva['hora_inicio']) && !empty($reserva['hora_fin'])) {
        return $reserva['hora_inicio'] . ' - ' . $reserva['hora_fin'];
    }
    return $reserva['hora'] ?? '';
}
