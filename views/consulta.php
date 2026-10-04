<?php require __DIR__ . '/helpers.php'; ?>
<?php require __DIR__ . '/partials/header.php'; ?>
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

<main class="max-w-6xl mx-auto px-6 py-8 relative z-10">
    <section class="bg-slate-900/80 backdrop-blur-xl rounded-3xl y2k-border glow-purple p-8 mb-8">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-purple-500/30">
            <div>
                <h2 class="text-xl font-black tracking-wide chrome-text rounded-chrome flex items-center gap-2">
                    <span>🔍</span> Directorio y Disponibilidad
                </h2>
                <p class="text-xs text-purple-300 mt-1">Selecciona los criterios para encontrar espacios libres al instante.</p>
            </div>
            <span class="bg-slate-800 text-purple-300 font-bold text-xs px-3 py-1.5 rounded-xl border border-purple-500/50">Filtros Activos</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-slate-800/60 p-3 rounded-2xl border border-purple-500/50">
                <label class="block text-xs font-bold text-purple-300 uppercase mb-1">Fecha</label>
                <input type="date" id="filtroFecha" onchange="validarHorario()"
                    class="w-full bg-slate-900/80 border border-purple-500/50 rounded-xl px-3 py-2 text-sm text-white focus:ring-2 focus:ring-purple-400 outline-none font-medium">
            </div>
            <div class="bg-slate-800/60 p-3 rounded-2xl border border-purple-500/50">
                <label class="block text-xs font-bold text-purple-300 uppercase mb-1">Horario</label>
                <select id="filtroHorario" onchange="validarHorario()"
                    class="w-full bg-slate-900/80 border border-purple-500/50 rounded-xl px-3 py-2 text-sm text-white focus:ring-2 focus:ring-purple-400 outline-none font-medium">
                    <option value="">-- Elige bloque --</option>
                    <?php foreach ($horarios as $h): ?>
                        <option value="<?= htmlspecialchars($h) ?>"><?= htmlspecialchars($h) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="bg-slate-800/60 p-3 rounded-2xl border border-purple-500/50">
                <label class="block text-xs font-bold text-purple-300 uppercase mb-1">Tipo de espacio</label>
                <select id="filtroTipo" onchange="filtrarTabla()"
                    class="w-full bg-slate-900/80 border border-purple-500/50 rounded-xl px-3 py-2 text-sm text-white focus:ring-2 focus:ring-purple-400 outline-none font-medium">
                    <option value="">Todos los tipos</option>
                    <option value="Aula Virtual">Aula Virtual</option>
                    <option value="Auditorio">Auditorio</option>
                </select>
            </div>
            <div class="flex items-end">
                <button onclick="filtrarTabla()" class="w-full uach-grad hover:opacity-95 text-white font-bold text-sm py-3.5 rounded-2xl shadow-lg shadow-purple-500/50 transition transform hover:-translate-y-0.5 glow-purple">
                    ✨ Filtrar Espacios
                </button>
            </div>
        </div>

        <div id="alertaHorario" class="hidden mb-6 p-4 rounded-2xl bg-red-900/50 border-2 border-red-500 text-red-200 text-xs font-bold flex items-center gap-3 shadow-sm glow-yellow">
            <span class="text-lg">🚨</span>
            <div>
                <span>Fuera del horario operativo permitido.</span>
                <span class="block text-[11px] font-normal text-red-300">Horarios válidos: Lunes a Viernes 8:00 AM - 8:00 PM / Sábados 9:00 AM - 12:00 PM</span>
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border-2 border-purple-500/50 shadow-lg bg-slate-900/80">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="bg-gradient-to-r from-purple-900 to-purple-800 text-white font-bold text-xs uppercase tracking-wider">
                        <th class="px-5 py-4">Espacio</th>
                        <th class="px-5 py-4">Tipo</th>
                        <th class="px-5 py-4">Estado</th>
                        <th class="px-5 py-4 text-center">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-purple-500/30 bg-slate-900/60 font-medium">
                    <?php foreach ($aulas as $aula): ?>
                    <tr class="hover:bg-purple-900/30 transition fila-aula" data-tipo="<?= htmlspecialchars($aula['tipo']) ?>">
                        <td class="px-5 py-4 font-bold text-white flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-500 glow-purple"></span>
                            <?= htmlspecialchars($aula['nombre']) ?>
                        </td>
                        <td class="px-5 py-4 text-purple-200"><?= htmlspecialchars($aula['tipo']) ?></td>
                        <td class="px-5 py-4">
                            <span class="px-3 py-1.5 rounded-xl text-xs shadow-sm <?= estadoBadgeClass($aula['estado']) ?>">
                                <?= htmlspecialchars($aula['estado']) ?>
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <button type="button" onclick="abrirModalReserva('<?= htmlspecialchars($aula['nombre'], ENT_QUOTES) ?>')"
                                class="bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900 text-white font-bold text-xs px-4 py-2 rounded-xl transition shadow-lg shadow-purple-500/50">
                                Reservar
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require __DIR__ . '/partials/modal.php'; ?>

<script>
const horarioOperativo = <?= json_encode($horarioOperativo) ?>;

function filtrarTabla() {
    const tipo = document.getElementById('filtroTipo').value;
    document.querySelectorAll('.fila-aula').forEach(fila => {
        fila.style.display = (!tipo || fila.dataset.tipo === tipo) ? '' : 'none';
    });
}

function validarHorario() {
    const fechaInput = document.getElementById('filtroFecha').value;
    const horarioSel = document.getElementById('filtroHorario').value;
    const alerta = document.getElementById('alertaHorario');

    if (!fechaInput || !horarioSel) {
        alerta.classList.add('hidden');
        return;
    }

    const fecha = new Date(fechaInput + 'T00:00:00');
    const diaSemana = fecha.getDay();
    const horaInicioSolicitud = horarioSel.split(' - ')[0];
    let dentroDeHorario = false;

    if (diaSemana >= 1 && diaSemana <= 5) {
        dentroDeHorario = horaInicioSolicitud >= horarioOperativo.labora.inicio && horaInicioSolicitud < horarioOperativo.labora.fin;
    } else if (diaSemana === 6) {
        dentroDeHorario = horaInicioSolicitud >= horarioOperativo.sabado.inicio && horaInicioSolicitud < horarioOperativo.sabado.fin;
    }

    alerta.classList.toggle('hidden', dentroDeHorario);
}

function abrirModalReserva(espacio) {
    if (espacio) {
        document.getElementById('resEspacio').value = espacio;
    }
    document.getElementById('modalReserva').classList.remove('hidden');
}

function cerrarModalReserva() {
    document.getElementById('modalReserva').classList.add('hidden');
}

function guardarReserva(e) {
    e.preventDefault();
    const espacio = document.getElementById('resEspacio').value;
    mostrarToast(`¡Reserva guardada con éxito para ${espacio}!`);
    cerrarModalReserva();
    e.target.reset();
    return false;
}

let toastTimeout;
function mostrarToast(mensaje) {
    const toast = document.getElementById('toast');
    const msg = document.getElementById('toastMsg');
    msg.textContent = mensaje;
    toast.classList.remove('hidden');
    clearTimeout(toastTimeout);
    toastTimeout = setTimeout(() => toast.classList.add('hidden'), 4000);
}
</script>

</body>
</html>
