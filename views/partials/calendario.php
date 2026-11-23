<section class="bg-white backdrop-blur-xl rounded-3xl y2k-border glow-wine p-8 mb-8">
    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
        <div>
            <h2 class="text-xl font-black tracking-wide text-[#7A1A2E]">Calendario mensual</h2>
            <p class="text-xs text-[#7A1A2E] mt-1">Cada bloque muestra la actividad programada por sala.</p>
        </div>
        <div class="flex flex-wrap gap-2 items-center">
            <button type="button" onclick="cambiarMes(-1)" class="px-3 py-2 rounded-xl border border-[#7A1A2E]/50 text-xs font-bold">◀</button>
            <span id="tituloMes" class="text-sm font-bold text-[#7A1A2E] min-w-[140px] text-center"></span>
            <button type="button" onclick="cambiarMes(1)" class="px-3 py-2 rounded-xl border border-[#7A1A2E]/50 text-xs font-bold">▶</button>
            <select id="filtroSalaCalendario" onchange="renderCalendario()" class="bg-white text-[#1A1A1A] border border-[#7A1A2E]/40 rounded-xl px-3 py-2 text-xs text-[#1A1A1A]">
                <option value="">Todas las salas</option>
                <?php foreach ($aulas as $aula): ?>
                    <option value="<?= htmlspecialchars($aula['nombre']) ?>"><?= htmlspecialchars($aula['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
            <select id="filtroDisponibles" onchange="renderCalendario(); filtrarTablaEspacios();" class="bg-white text-[#1A1A1A] border border-[#7A1A2E]/40 rounded-xl px-3 py-2 text-xs text-[#1A1A1A]">
                <option value="">Salas: todas</option>
                <option value="Disponible">Solo disponibles</option>
            </select>
            <button type="button" onclick="verReservasDelDia()" class="fca-grad text-white font-bold text-xs px-4 py-2 rounded-xl glow-wine">Ver reservas del día</button>
        </div>
    </div>
    <div class="cal-grid mb-2 text-[11px] font-bold uppercase text-[#7A1A2E] text-center">
        <div>Lun</div><div>Mar</div><div>Mié</div><div>Jue</div><div>Vie</div><div>Sáb</div><div>Dom</div>
    </div>
    <div id="calendarioMes" class="cal-grid"></div>
</section>
