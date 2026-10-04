<?php
function estadoBadgeClass($estado) {
    switch ($estado) {
        case "Disponible":
        case "Confirmada":
        case "Completada":
            return "bg-green-900/60 text-green-400 border border-green-500/50 font-bold";
        case "Ocupada":
        case "Cancelada":
            return "bg-red-900/60 text-red-400 border border-red-500/50 font-bold";
        case "Mantenimiento":
        case "Pendiente":
            return "bg-yellow-900/60 text-yellow-400 border border-yellow-500/50 font-bold";
        case "En curso":
        default:
            return "bg-purple-900/60 text-purple-400 border border-purple-500/50 font-bold";
    }
}

function insumosTexto(array $insumos): string
{
    if (empty($insumos)) {
        return 'Sin insumos';
    }
    return implode(', ', $insumos);
}
