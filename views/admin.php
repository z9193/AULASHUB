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
    <section class="bg-slate-900/80 backdrop-blur-xl rounded-3xl y2k-border glow-purple p-8">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 pb-4 border-b border-purple-500/30">
            <div>
                <h2 class="text-xl font-black tracking-wide chrome-text rounded-chrome flex items-center gap-2">
                    <span>🛠️</span> Centro de Control Administrativo
                </h2>
                <p class="text-xs text-purple-300 mt-1">Administra reservas, asigna insumos y controla métricas en tiempo real.</p>
            </div>
            <div class="flex gap-3">
                <button onclick="abrirModalReserva()"
                    class="uach-grad hover:opacity-95 text-white font-bold text-xs px-5 py-3 rounded-2xl shadow-lg shadow-purple-500/50 transition transform hover:-translate-y-0.5 glow-purple">
                    ➕ Nueva Reserva
                </button>
                <button onclick="simularRecordatorio()"
                    class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-bold text-xs px-5 py-3 rounded-2xl shadow-lg shadow-yellow-500/50 transition transform hover:-translate-y-0.5 glow-yellow">
                    ⏰ Lanzar Alarma
                </button>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-gradient-to-br from-purple-900/60 to-purple-800/40 border-2 border-purple-500/50 rounded-2xl p-5 shadow-lg glow-purple">
                <p class="text-[11px] font-bold uppercase tracking-wider text-purple-300">Espacios</p>
                <p id="metricaTotalEspacios" class="text-3xl font-extrabold text-yellow-400 text-glow mt-1"><?= (int)$metricas['totalEspacios'] ?></p>
                <p class="text-xs text-purple-300 mt-1">Auditorio y Aula Virtual</p>
            </div>
            <div class="bg-gradient-to-br from-green-900/60 to-green-800/40 border-2 border-green-500/50 rounded-2xl p-5 shadow-lg glow-green">
                <p class="text-[11px] font-bold uppercase tracking-wider text-green-300">Disponibles</p>
                <p id="metricaDisponibles" class="text-3xl font-extrabold text-green-400 text-glow mt-1"><?= (int)$metricas['disponibles'] ?></p>
                <p class="text-xs text-purple-300 mt-1">Ocupadas: <?= (int)$metricas['ocupadas'] ?> · Mant.: <?= (int)$metricas['enMantenimiento'] ?></p>
            </div>
            <div class="bg-gradient-to-br from-purple-900/60 to-purple-800/40 border-2 border-purple-500/50 rounded-2xl p-5 shadow-lg glow-purple">
                <p class="text-[11px] font-bold uppercase tracking-wider text-purple-300">Reservas</p>
                <p id="metricaTotalReservas" class="text-3xl font-extrabold text-yellow-400 text-glow mt-1"><?= (int)$metricas['totalReservas'] ?></p>
                <p class="text-xs text-purple-300 mt-1">Historial acumulado</p>
            </div>
            <div class="bg-gradient-to-br from-yellow-900/60 to-yellow-800/40 border-2 border-yellow-500/50 rounded-2xl p-5 shadow-lg glow-yellow">
                <p class="text-[11px] font-bold uppercase tracking-wider text-yellow-300">Pendientes</p>
                <p id="metricaPendientes" class="text-3xl font-extrabold text-yellow-400 text-glow mt-1"><?= (int)$metricas['pendientes'] ?></p>
                <p class="text-xs text-purple-300 mt-1">Confirmadas: <span id="metricaConfirmadas"><?= (int)$metricas['confirmadas'] ?></span> · En curso: <?= (int)$metricas['enCurso'] ?></p>
            </div>
        </div>

        <div class="border-2 border-purple-500/50 rounded-2xl p-6 bg-slate-900/60 shadow-lg glow-purple">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-black tracking-wide chrome-text rounded-chrome text-sm flex items-center gap-2">
                    <span>📝</span> Historial de reservas
                </h3>
                <span id="contadorRegistros" class="bg-slate-800 text-purple-300 font-bold text-xs px-3 py-1.5 rounded-xl border border-purple-500/50"><?= (int)$metricas['totalReservas'] ?> registros</span>
            </div>
            <div class="overflow-x-auto rounded-2xl border-2 border-purple-500/50 bg-slate-900/80 shadow-lg">
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-purple-900 to-purple-800 text-white font-bold text-xs uppercase tracking-wider">
                            <th class="px-5 py-4">Responsable</th>
                            <th class="px-5 py-4">Espacio</th>
                            <th class="px-5 py-4">Fecha</th>
                            <th class="px-5 py-4">Hora</th>
                            <th class="px-5 py-4">Insumos / Recursos</th>
                            <th class="px-5 py-4">Estado</th>
                        </tr>
                    </thead>
                    <tbody id="tablaHistorialReservas" class="divide-y divide-purple-500/30 font-medium">
                        <?php if (empty($reservas)): ?>
                        <tr id="historialVacio">
                            <td colspan="6" class="px-5 py-6 text-center italic text-purple-400">No hay reservas registradas todavía.</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach ($reservas as $reserva): ?>
                            <tr class="hover:bg-purple-900/30 transition">
                                <td class="px-5 py-4 font-bold text-white"><?= htmlspecialchars($reserva['responsable']) ?></td>
                                <td class="px-5 py-4 text-purple-200"><?= htmlspecialchars($reserva['espacio']) ?></td>
                                <td class="px-5 py-4 text-purple-200 whitespace-nowrap"><?= htmlspecialchars($reserva['fecha']) ?></td>
                                <td class="px-5 py-4 text-purple-200 whitespace-nowrap"><?= htmlspecialchars($reserva['hora']) ?></td>
                                <td class="px-5 py-4 text-purple-200 text-xs">
                                    <?php if (empty($reserva['insumos'])): ?>
                                        <span class="italic text-purple-400">Sin insumos</span>
                                    <?php else: ?>
                                        <div class="flex flex-wrap gap-1.5">
                                            <?php foreach ($reserva['insumos'] as $insumo): ?>
                                                <span class="bg-purple-900/60 text-purple-200 border border-purple-500/50 px-2 py-1 rounded-lg font-semibold"><?= htmlspecialchars($insumo) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="px-3 py-1.5 rounded-xl text-xs shadow-sm <?= estadoBadgeClass($reserva['estado']) ?>">
                                        <?= htmlspecialchars($reserva['estado']) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . '/partials/modal.php'; ?>

<script>
function abrirModalReserva(espacio) {
    if (espacio) {
        document.getElementById('resEspacio').value = espacio;
    }
    document.getElementById('modalReserva').classList.remove('hidden');
}

function cerrarModalReserva() {
    document.getElementById('modalReserva').classList.add('hidden');
}

function escapeHtml(texto) {
    const div = document.createElement('div');
    div.textContent = texto;
    return div.innerHTML;
}

function renderInsumos(insumos) {
    if (!insumos.length) {
        return '<span class="italic text-purple-400">Sin insumos</span>';
    }
    return `<div class="flex flex-wrap gap-1.5">${insumos.map(item =>
        `<span class="bg-purple-900/60 text-purple-200 border border-purple-500/50 px-2 py-1 rounded-lg font-semibold">${escapeHtml(item)}</span>`
    ).join('')}</div>`;
}

function agregarFilaHistorial(reserva) {
    const tbody = document.getElementById('tablaHistorialReservas');
    const vacio = document.getElementById('historialVacio');
    if (vacio) vacio.remove();

    const tr = document.createElement('tr');
    tr.className = 'hover:bg-purple-900/30 transition';
    tr.innerHTML = `
        <td class="px-5 py-4 font-bold text-white">${escapeHtml(reserva.responsable)}</td>
        <td class="px-5 py-4 text-purple-200">${escapeHtml(reserva.espacio)}</td>
        <td class="px-5 py-4 text-purple-200 whitespace-nowrap">${escapeHtml(reserva.fecha)}</td>
        <td class="px-5 py-4 text-purple-200 whitespace-nowrap">${escapeHtml(reserva.hora)}</td>
        <td class="px-5 py-4 text-purple-200 text-xs">${renderInsumos(reserva.insumos)}</td>
        <td class="px-5 py-4">
            <span class="px-3 py-1.5 rounded-xl text-xs shadow-sm bg-green-900/60 text-green-400 border border-green-500/50 font-bold">
                ${escapeHtml(reserva.estado)}
            </span>
        </td>
    `;
    tbody.prepend(tr);
}

function incrementarMetrica(id) {
    const nodo = document.getElementById(id);
    if (!nodo) return;
    nodo.textContent = String(parseInt(nodo.textContent, 10) + 1);
}

function guardarReserva(e) {
    e.preventDefault();

    const espacio = document.getElementById('resEspacio').value;
    const fecha = document.getElementById('resFecha').value;
    const horario = document.getElementById('resHorario').value;
    const responsable = document.getElementById('resResponsable').value;
    const insumos = Array.from(document.querySelectorAll('input[name="insumos[]"]:checked')).map(cb => cb.value);

    agregarFilaHistorial({
        responsable,
        espacio,
        fecha,
        hora: horario,
        estado: 'Confirmada',
        insumos
    });

    incrementarMetrica('metricaTotalReservas');
    incrementarMetrica('metricaConfirmadas');
    const contador = document.getElementById('contadorRegistros');
    const total = document.getElementById('metricaTotalReservas');
    if (contador && total) {
        contador.textContent = total.textContent + ' registros';
    }

    mostrarToast(`¡Reserva guardada con éxito para ${espacio}!`);
    cerrarModalReserva();
    e.target.reset();
    return false;
}

function simularRecordatorio() {
    mostrarToast('⏰ Alarma y notificación simulada enviada correctamente.');
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
