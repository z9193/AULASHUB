<div id="modalReserva" class="hidden fixed inset-0 modal-backdrop flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl y2k-border shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-8">
        <div class="flex items-center justify-between pb-4 border-b-2 border-[#7A1A2E]/20 mb-6">
            <h3 class="font-black text-[#7A1A2E] text-lg">Nueva reserva</h3>
            <button type="button" onclick="cerrarModalReserva()" class="w-9 h-9 rounded-full bg-[#F7F4F5] text-[#7A1A2E] hover:bg-[#7A1A2E] hover:text-white font-bold flex items-center justify-center text-xl border border-[#7A1A2E]/40">&times;</button>
        </div>

        <form onsubmit="return guardarReserva(event)" class="space-y-4">
            <p class="text-[11px] text-[#7A1A2E]"><?= htmlspecialchars($facultad) ?></p>
            <div>
                <label class="block text-xs font-bold text-[#7A1A2E] uppercase mb-1">Espacio</label>
                <select id="resEspacio" required onchange="actualizarInsumosPorEspacio()" class="w-full bg-[#F7F4F5] border-2 border-[#7A1A2E]/30 rounded-2xl px-4 py-3 text-sm text-[#1A1A1A] outline-none focus:ring-2 focus:ring-[#7A1A2E]">
                    <?php foreach ($aulas as $aula): ?>
                        <option value="<?= htmlspecialchars($aula['nombre']) ?>"><?= htmlspecialchars($aula['nombre']) ?> (<?= htmlspecialchars($aula['tipo']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-[#7A1A2E] uppercase mb-1">Actividad / motivo</label>
                <input type="text" id="resActividad" required placeholder="Ej. Junta de academia"
                    class="w-full bg-[#F7F4F5] border-2 border-[#7A1A2E]/30 rounded-2xl px-4 py-3 text-sm text-[#1A1A1A] outline-none focus:ring-2 focus:ring-[#7A1A2E]">
            </div>
            <div>
                <label class="block text-xs font-bold text-[#7A1A2E] uppercase mb-1">Fecha</label>
                <input type="date" id="resFecha" required class="w-full bg-[#F7F4F5] border-2 border-[#7A1A2E]/30 rounded-2xl px-4 py-3 text-sm text-[#1A1A1A] outline-none focus:ring-2 focus:ring-[#7A1A2E]">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-[#7A1A2E] uppercase mb-1">Hora inicio</label>
                    <select id="resHoraInicio" required class="w-full bg-[#F7F4F5] border-2 border-[#7A1A2E]/30 rounded-2xl px-4 py-3 text-sm text-[#1A1A1A] outline-none focus:ring-2 focus:ring-[#7A1A2E]">
                        <?php foreach ($horas as $h): ?>
                            <option value="<?= htmlspecialchars($h) ?>"><?= htmlspecialchars($h) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#7A1A2E] uppercase mb-1">Hora fin</label>
                    <select id="resHoraFin" required class="w-full bg-[#F7F4F5] border-2 border-[#7A1A2E]/30 rounded-2xl px-4 py-3 text-sm text-[#1A1A1A] outline-none focus:ring-2 focus:ring-[#7A1A2E]">
                        <?php foreach ($horas as $h): ?>
                            <option value="<?= htmlspecialchars($h) ?>"><?= htmlspecialchars($h) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-[#7A1A2E] uppercase mb-1">Responsable</label>
                <input type="text" id="resResponsable" required value="<?= htmlspecialchars($usuarioActual['nombre'] ?? '') ?>"
                    class="w-full bg-[#F7F4F5] border-2 border-[#7A1A2E]/30 rounded-2xl px-4 py-3 text-sm text-[#1A1A1A] outline-none focus:ring-2 focus:ring-[#7A1A2E]">
            </div>
            <div>
                <label class="block text-xs font-bold text-[#7A1A2E] uppercase mb-1">Insumos y recursos</label>
                <div class="grid grid-cols-2 gap-2 border-2 border-[#7A1A2E]/20 rounded-2xl p-4 bg-[#F7F4F5] max-h-40 overflow-y-auto">
                    <?php foreach ($insumosAuditorio as $insumo): ?>
                        <?php $soloAuditorio = mb_strtolower($insumo) === 'presídium'; ?>
                        <label class="insumo-opcion flex items-center gap-2 text-xs font-semibold text-[#1A1A1A] cursor-pointer<?= $soloAuditorio ? ' hidden' : '' ?>"<?= $soloAuditorio ? ' data-solo-auditorio="1"' : '' ?>>
                            <input type="checkbox" name="insumos[]" value="<?= htmlspecialchars($insumo) ?>" class="rounded text-[#7A1A2E] focus:ring-[#7A1A2E] w-4 h-4"<?= $soloAuditorio ? ' data-solo-auditorio="1"' : '' ?>>
                            <?= htmlspecialchars($insumo) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <p id="alertaReserva" class="hidden text-xs font-bold text-red-700 bg-red-50 border border-red-400 rounded-xl p-3"></p>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="cerrarModalReserva()" class="px-5 py-3 rounded-2xl border-2 border-[#7A1A2E] text-xs font-bold text-[#7A1A2E] hover:bg-[#F7F4F5]">Cancelar</button>
                <button type="submit" class="px-6 py-3 rounded-2xl bg-[#7A1A2E] text-white font-bold text-xs">Guardar reserva</button>
            </div>
        </form>
    </div>
</div>

<div id="modalDia" class="hidden fixed inset-0 modal-backdrop flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl y2k-border shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto p-8">
        <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b-2 border-[#7A1A2E]/20 mb-4">
            <h3 class="font-black text-[#7A1A2E] text-lg">Reporte del día <span id="tituloDia"></span></h3>
            <div class="flex items-center gap-2">
                <button type="button" onclick="descargarReportePdf()"
                    class="bg-[#7A1A2E] hover:bg-[#5C1423] text-white font-bold text-xs px-4 py-2.5 rounded-xl">
                    Descargar PDF
                </button>
                <button type="button" onclick="cerrarModalDia()" class="w-9 h-9 rounded-full bg-[#F7F4F5] text-[#7A1A2E] font-bold border border-[#7A1A2E]/40">&times;</button>
            </div>
        </div>
        <div id="contenidoDia" class="text-[#1A1A1A]"></div>
    </div>
</div>

<div id="toast" class="toast hidden fixed bottom-6 right-6 bg-[#7A1A2E] border-2 border-[#1A1A1A] text-white text-xs px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 z-50">
    <span id="toastMsg" class="font-bold"></span>
</div>
