<style>
    .chrome-text {
        background: linear-gradient(180deg, #fef3c7 0%, #fcd34d 25%, #f59e0b 50%, #d97706 75%, #b45309 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 0 20px rgba(245, 158, 11, 0.8), 0 0 40px rgba(245, 158, 11, 0.4);
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));
    }
    .rounded-chrome {
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
</style>
<div id="modalReserva" class="hidden fixed inset-0 modal-backdrop flex items-center justify-center z-50 p-4">
    <div class="bg-slate-900/90 backdrop-blur-xl rounded-3xl y2k-border glow-purple shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-8">
        <div class="flex items-center justify-between pb-4 border-b-2 border-purple-500/30 mb-6">
            <h3 class="font-black tracking-wide chrome-text rounded-chrome text-lg flex items-center gap-2"><span>📅</span> Asignar Nuevo Espacio</h3>
            <button onclick="cerrarModalReserva()" class="w-9 h-9 rounded-full bg-slate-800 text-purple-300 hover:bg-slate-700 font-bold flex items-center justify-center text-xl transition border border-purple-500/50">&times;</button>
        </div>

        <form onsubmit="return guardarReserva(event)" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-purple-300 uppercase mb-1">Espacio a Reservar</label>
                <select id="resEspacio" required class="w-full bg-slate-800/80 border-2 border-purple-500/50 rounded-2xl px-4 py-3 text-sm text-white font-medium outline-none focus:ring-2 focus:ring-purple-400">
                    <?php foreach ($aulas as $aula): ?>
                        <option value="<?= htmlspecialchars($aula['nombre']) ?>"><?= htmlspecialchars($aula['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-purple-300 uppercase mb-1">Fecha</label>
                    <input type="date" id="resFecha" required class="w-full bg-slate-800/80 border-2 border-purple-500/50 rounded-2xl px-4 py-3 text-sm text-white font-medium outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div>
                    <label class="block text-xs font-bold text-purple-300 uppercase mb-1">Horario</label>
                    <select id="resHorario" required class="w-full bg-slate-800/80 border-2 border-purple-500/50 rounded-2xl px-4 py-3 text-sm text-white font-medium outline-none focus:ring-2 focus:ring-purple-400">
                        <?php foreach ($horarios as $h): ?>
                            <option value="<?= htmlspecialchars($h) ?>"><?= htmlspecialchars($h) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-purple-300 uppercase mb-1">Responsable del Evento</label>
                <input type="text" id="resResponsable" placeholder="Nombre completo del docente o área" required
                    class="w-full bg-slate-800/80 border-2 border-purple-500/50 rounded-2xl px-4 py-3 text-sm text-white font-medium outline-none focus:ring-2 focus:ring-purple-400">
            </div>

            <div>
                <label class="block text-xs font-bold text-purple-300 uppercase mb-1">Insumos y Recursos Adicionales</label>
                <div class="grid grid-cols-2 gap-2 border-2 border-purple-500/50 rounded-2xl p-4 bg-slate-800/60 max-h-40 overflow-y-auto">
                    <?php foreach ($insumosAuditorio as $insumo): ?>
                        <label class="flex items-center gap-2 text-xs font-semibold text-purple-200 cursor-pointer">
                            <input type="checkbox" name="insumos[]" value="<?= htmlspecialchars($insumo) ?>" class="rounded text-purple-600 focus:ring-purple-400 w-4 h-4">
                            <?= htmlspecialchars($insumo) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="cerrarModalReserva()"
                    class="px-5 py-3 rounded-2xl border-2 border-purple-500/50 text-xs font-bold text-purple-300 hover:bg-slate-800 transition">Cancelar</button>
                <button type="submit"
                    class="px-6 py-3 rounded-2xl uach-grad text-white font-bold text-xs shadow-lg shadow-purple-500/50 hover:opacity-95 transition glow-purple">Guardar Reserva</button>
            </div>
        </form>
    </div>
</div>

<div id="toast" class="toast hidden fixed bottom-6 right-6 bg-slate-900 border-2 border-yellow-500 text-white text-xs px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 z-50 glow-yellow">
    <span class="text-xl">✨</span>
    <span id="toastMsg" class="font-bold"></span>
</div>
