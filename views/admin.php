<?php require __DIR__ . '/helpers.php'; ?>
<?php require __DIR__ . '/partials/header.php'; ?>

<main class="max-w-7xl mx-auto px-6 py-8 relative z-10">
    <section class="bg-white backdrop-blur-xl rounded-3xl y2k-border glow-wine p-8 mb-8">
        <div class="mb-6 pb-4 border-b border-[#7A1A2E]/30">
            <h2 class="text-xl font-black tracking-wide text-[#7A1A2E]">Panel administrativo</h2>
            <p class="text-xs text-[#7A1A2E] mt-1"><?= htmlspecialchars($facultad) ?> · métricas, reservas y salas.</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <button type="button" onclick="abrirModalReserva()"
                class="bg-[#7A1A2E] hover:bg-[#5C1423] rounded-2xl p-5 text-white text-left transition transform hover:-translate-y-0.5 hover:shadow-lg">
                <p class="text-[11px] font-bold uppercase tracking-wider">Acción</p>
                <p class="text-2xl font-extrabold mt-1">Nueva reserva</p>
                <p class="text-xs mt-1 opacity-80">Registrar un espacio</p>
            </button>
            <div class="bg-white border-2 border-[#7A1A2E] rounded-2xl p-5">
                <p class="text-[11px] font-bold uppercase tracking-wider text-[#7A1A2E]">Disponibles</p>
                <p id="metricaDisponibles" class="text-3xl font-extrabold text-[#7A1A2E] mt-1"><?= (int)$metricas['disponibles'] ?></p>
                <p class="text-xs mt-1">Ocupadas: <?= (int)$metricas['ocupadas'] ?></p>
            </div>
            <button type="button" onclick="verReservasDelDia()"
                class="bg-[#7A1A2E] hover:bg-[#5C1423] rounded-2xl p-5 text-white text-left transition transform hover:-translate-y-0.5 hover:shadow-lg">
                <p class="text-[11px] font-bold uppercase tracking-wider">Acción</p>
                <p class="text-2xl font-extrabold mt-1">Reporte del día</p>
                <p class="text-xs mt-1 opacity-80">Ver y descargar PDF</p>
            </button>
            <div class="bg-white border-2 border-[#7A1A2E] rounded-2xl p-5">
                <p class="text-[11px] font-bold uppercase tracking-wider text-[#7A1A2E]">Pendientes</p>
                <p id="metricaPendientes" class="text-3xl font-extrabold text-[#7A1A2E] mt-1"><?= (int)$metricas['pendientes'] ?></p>
                <p class="text-xs mt-1">Confirmadas: <span id="metricaConfirmadas"><?= (int)$metricas['confirmadas'] ?></span></p>
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border-2 border-[#7A1A2E]/40 mb-4">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-[#7A1A2E] text-white text-xs uppercase">
                        <th class="px-4 py-3 text-left">Espacio</th>
                        <th class="px-4 py-3 text-left">Tipo</th>
                        <th class="px-4 py-3 text-left">Piso</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($aulas as $aula): ?>
                    <tr class="fila-aula border-t border-[#7A1A2E]/20" data-tipo="<?= htmlspecialchars($aula['tipo']) ?>" data-nombre="<?= htmlspecialchars($aula['nombre']) ?>" data-estado="<?= htmlspecialchars($aula['estado']) ?>">
                        <td class="px-4 py-3 font-bold"><?= htmlspecialchars($aula['nombre']) ?></td>
                        <td class="px-4 py-3"><?= htmlspecialchars($aula['tipo']) ?></td>
                        <td class="px-4 py-3"><?= htmlspecialchars($aula['piso']) ?></td>
                        <td class="px-4 py-3"><span class="px-2 py-1 rounded-lg text-xs <?= estadoBadgeClass($aula['estado']) ?>"><?= htmlspecialchars($aula['estado']) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <?php require __DIR__ . '/partials/calendario.php'; ?>

    <section class="bg-white backdrop-blur-xl rounded-3xl y2k-border glow-wine p-8 mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-black text-[#7A1A2E] text-sm">Historial de reservas</h3>
            <span id="contadorRegistros" class="text-xs font-bold text-[#7A1A2E]"><?= (int)$metricas['totalReservas'] ?> registros</span>
        </div>
        <div class="overflow-x-auto rounded-2xl border-2 border-[#7A1A2E]/40">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-[#7A1A2E] text-white text-xs uppercase">
                        <th class="px-5 py-4">Responsable</th>
                        <th class="px-5 py-4">Espacio</th>
                        <th class="px-5 py-4">Actividad</th>
                        <th class="px-5 py-4">Fecha</th>
                        <th class="px-5 py-4">Horario</th>
                        <th class="px-5 py-4">Insumos</th>
                        <th class="px-5 py-4">Estado</th>
                    </tr>
                </thead>
                <tbody id="tablaHistorialReservas" class="divide-y divide-[#C9A227]/20">
                    <?php if (empty($reservas)): ?>
                    <tr id="historialVacio"><td colspan="7" class="px-5 py-6 text-center italic text-[#7A1A2E]">Sin reservas.</td></tr>
                    <?php else: foreach ($reservas as $reserva): ?>
                    <tr>
                        <td class="px-5 py-4 font-bold"><?= htmlspecialchars($reserva['responsable']) ?></td>
                        <td class="px-5 py-4"><?= htmlspecialchars($reserva['espacio']) ?></td>
                        <td class="px-5 py-4"><?= htmlspecialchars($reserva['actividad'] ?? '') ?></td>
                        <td class="px-5 py-4 whitespace-nowrap"><?= htmlspecialchars($reserva['fecha']) ?></td>
                        <td class="px-5 py-4 whitespace-nowrap"><?= htmlspecialchars(horarioReserva($reserva)) ?></td>
                        <td class="px-5 py-4 text-xs">
                            <?php if (empty($reserva['insumos'])): ?>
                                <span class="italic text-[#7A1A2E]/70">Sin insumos</span>
                            <?php else: foreach ($reserva['insumos'] as $insumo): ?>
                                <span class="inline-block bg-[#7A1A2E]/70 border border-[#7A1A2E]/40 px-2 py-1 rounded-lg mr-1 mb-1"><?= htmlspecialchars($insumo) ?></span>
                            <?php endforeach; endif; ?>
                        </td>
                        <td class="px-5 py-4"><span class="px-3 py-1.5 rounded-xl text-xs <?= estadoBadgeClass($reserva['estado']) ?>"><?= htmlspecialchars($reserva['estado']) ?></span></td>
                    </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require __DIR__ . '/partials/modal.php'; ?>
<?php require __DIR__ . '/partials/config-js.php'; ?>
</body>
</html>
