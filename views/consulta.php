<?php require __DIR__ . '/helpers.php'; ?>
<?php require __DIR__ . '/partials/header.php'; ?>

<main class="max-w-7xl mx-auto px-6 py-8 relative z-10">
    <section class="bg-white backdrop-blur-xl rounded-3xl y2k-border glow-wine p-8 mb-8">
        <div class="mb-6 pb-4 border-b border-[#7A1A2E]/30">
            <h2 class="text-xl font-black tracking-wide text-[#7A1A2E]">Directorio de espacios</h2>
            <p class="text-xs text-[#7A1A2E] mt-1"><?= htmlspecialchars($facultad) ?> · Aula, auditorio y salas de juntas.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-[#F7F4F5] p-3 rounded-2xl border border-[#7A1A2E]/40">
                <label class="block text-xs font-bold text-[#7A1A2E] uppercase mb-1">Fecha</label>
                <input type="date" id="filtroFecha" class="w-full bg-white border border-[#7A1A2E]/40 rounded-xl px-3 py-2 text-sm text-[#1A1A1A] outline-none">
            </div>
            <div class="bg-[#F7F4F5] p-3 rounded-2xl border border-[#7A1A2E]/40">
                <label class="block text-xs font-bold text-[#7A1A2E] uppercase mb-1">Tipo</label>
                <select id="filtroTipo" onchange="filtrarTablaEspacios()" class="w-full bg-white border border-[#7A1A2E]/40 rounded-xl px-3 py-2 text-sm text-[#1A1A1A]">
                    <option value="">Todos</option>
                    <option value="Aula">Aula</option>
                    <option value="Auditorio">Auditorio</option>
                    <option value="Sala de juntas">Sala de juntas</option>
                </select>
            </div>
            <div class="bg-[#F7F4F5] p-3 rounded-2xl border border-[#7A1A2E]/40">
                <label class="block text-xs font-bold text-[#7A1A2E] uppercase mb-1">Tu horario</label>
                <p class="text-sm font-semibold text-[#1A1A1A] py-2"><?= htmlspecialchars($usuarioActual['horario_inicio']) ?> – <?= htmlspecialchars($usuarioActual['horario_fin']) ?></p>
            </div>
            <div class="flex items-end">
                <button type="button" onclick="filtrarTablaEspacios()" class="w-full fca-grad text-white font-bold text-sm py-3.5 rounded-2xl">Filtrar espacios</button>
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border-2 border-[#7A1A2E]/40 bg-white/80">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-[#7A1A2E] text-white font-bold text-xs uppercase tracking-wider">
                        <th class="px-5 py-4">Espacio</th>
                        <th class="px-5 py-4">Tipo</th>
                        <th class="px-5 py-4">Piso</th>
                        <th class="px-5 py-4">Estado</th>
                        <th class="px-5 py-4 text-center">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#C9A227]/20">
                    <?php foreach ($aulas as $aula): ?>
                    <tr class="hover:bg-[#7A1A2E]/25 fila-aula" data-tipo="<?= htmlspecialchars($aula['tipo']) ?>" data-nombre="<?= htmlspecialchars($aula['nombre']) ?>" data-estado="<?= htmlspecialchars($aula['estado']) ?>">
                        <td class="px-5 py-4 font-bold"><?= htmlspecialchars($aula['nombre']) ?></td>
                        <td class="px-5 py-4 text-[#7A1A2E]"><?= htmlspecialchars($aula['tipo']) ?></td>
                        <td class="px-5 py-4 text-[#1A1A1A]/80"><?= htmlspecialchars($aula['piso']) ?></td>
                        <td class="px-5 py-4"><span class="px-3 py-1.5 rounded-xl text-xs <?= estadoBadgeClass($aula['estado']) ?>"><?= htmlspecialchars($aula['estado']) ?></span></td>
                        <td class="px-5 py-4 text-center">
                            <button type="button" onclick="abrirModalReserva('<?= htmlspecialchars($aula['nombre'], ENT_QUOTES) ?>')" class="bg-[#7A1A2E] hover:bg-[#5C1423] text-white font-bold text-xs px-4 py-2 rounded-xl">Reservar</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <?php require __DIR__ . '/partials/calendario.php'; ?>

    <section class="bg-white backdrop-blur-xl rounded-3xl y2k-border glow-wine p-8">
        <h2 class="text-xl font-black text-[#7A1A2E] mb-2">Requisitos del usuario</h2>
        <p class="text-xs text-[#7A1A2E] mb-4">Documentos y condiciones para solicitar espacios en <?= htmlspecialchars($facultad) ?>.</p>
        <ul class="space-y-2">
            <?php foreach ($usuarioActual['requisitos'] as $req): ?>
                <li class="flex items-center gap-3 bg-[#F7F4F5] border border-[#7A1A2E]/30 rounded-xl px-4 py-3 text-sm">
                    <span class="w-2 h-2 rounded-full bg-[#7A1A2E]"></span>
                    <?= htmlspecialchars($req) ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <p class="text-xs text-[#7A1A2E] mt-4">Horario autorizado: <b><?= htmlspecialchars($usuarioActual['horario_inicio']) ?> – <?= htmlspecialchars($usuarioActual['horario_fin']) ?></b></p>
    </section>
</main>

<?php require __DIR__ . '/partials/modal.php'; ?>
<?php require __DIR__ . '/partials/config-js.php'; ?>
</body>
</html>
