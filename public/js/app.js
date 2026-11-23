function horaAMinutos(hora) {
    const [h, m] = String(hora).split(':').map(Number);
    return h * 60 + (m || 0);
}

function hayTraslapo(aIni, aFin, bIni, bFin) {
    return horaAMinutos(aIni) < horaAMinutos(bFin) && horaAMinutos(bIni) < horaAMinutos(aFin);
}

function reservasActivas() {
    return (window.RESERVAS || []).filter((r) => r.estado !== 'Cancelada');
}

function validarReserva(espacio, fecha, inicio, fin) {
    if (!fecha || !inicio || !fin) return 'Completa fecha, hora de inicio y hora de fin.';
    if (horaAMinutos(fin) <= horaAMinutos(inicio)) return 'La hora de fin debe ser posterior a la hora de inicio.';

    const operativo = window.HORARIO_OPERATIVO || {};
    const dia = new Date(fecha + 'T00:00:00').getDay();
    const ventana = dia === 6 ? operativo.sabado : (dia === 0 ? null : operativo.labora);
    if (!ventana) return 'No hay horario operativo los domingos.';
    if (inicio < ventana.inicio || fin > ventana.fin) {
        return `Fuera del horario operativo (${ventana.inicio} – ${ventana.fin}).`;
    }

    const userIni = window.USUARIO_ACTUAL?.horario_inicio;
    const userFin = window.USUARIO_ACTUAL?.horario_fin;
    if (userIni && userFin && (inicio < userIni || fin > userFin)) {
        return `Tu horario autorizado es ${userIni} – ${userFin}.`;
    }

    const choque = reservasActivas().some((r) =>
        r.espacio === espacio && r.fecha === fecha && hayTraslapo(inicio, fin, r.hora_inicio, r.hora_fin)
    );
    if (choque) return 'Ese espacio ya tiene una reserva en el horario elegido.';
    return '';
}

function esEspacioAuditorio(nombre) {
    return String(nombre || '').trim().toLowerCase() === 'auditorio';
}

function actualizarInsumosPorEspacio() {
    const esAuditorio = esEspacioAuditorio(document.getElementById('resEspacio')?.value);
    document.querySelectorAll('[data-solo-auditorio="1"]').forEach((el) => {
        el.classList.toggle('hidden', !esAuditorio);
        if (!esAuditorio && el.matches('input')) {
            el.checked = false;
            el.disabled = true;
        } else if (el.matches('input')) {
            el.disabled = false;
        }
        const input = el.querySelector?.('input[type="checkbox"]');
        if (input) {
            input.disabled = !esAuditorio;
            if (!esAuditorio) input.checked = false;
        }
    });
}

function insumosPermitidos(espacio) {
    const esAuditorio = esEspacioAuditorio(espacio);
    return Array.from(document.querySelectorAll('input[name="insumos[]"]:checked'))
        .filter((cb) => !cb.disabled)
        .map((cb) => cb.value)
        .filter((nombre) => {
            if (/silla/i.test(nombre)) return false;
            if (!esAuditorio && /^pres[ií]dium$/i.test(nombre)) return false;
            return true;
        });
}

function abrirModalReserva(espacio) {
    if (espacio) document.getElementById('resEspacio').value = espacio;
    document.getElementById('alertaReserva')?.classList.add('hidden');
    actualizarInsumosPorEspacio();
    document.getElementById('modalReserva').classList.remove('hidden');
}

function cerrarModalReserva() {
    document.getElementById('modalReserva').classList.add('hidden');
}

function cerrarModalDia() {
    document.getElementById('modalDia').classList.add('hidden');
}

function escapeHtml(texto) {
    const div = document.createElement('div');
    div.textContent = texto ?? '';
    return div.innerHTML;
}

function renderInsumos(insumos) {
    if (!insumos || !insumos.length) return '<span class="italic text-[#7A1A2E]/70">Sin insumos</span>';
    return `<div class="flex flex-wrap gap-1.5">${insumos.map((item) =>
        `<span class="bg-[#7A1A2E] text-white px-2 py-1 rounded-lg font-semibold">${escapeHtml(item)}</span>`
    ).join('')}</div>`;
}

function mesActual() {
    if (!window._mesVista) {
        const hoy = new Date();
        window._mesVista = { y: hoy.getFullYear(), m: hoy.getMonth() };
    }
    return window._mesVista;
}

function cambiarMes(delta) {
    const mes = mesActual();
    mes.m += delta;
    if (mes.m < 0) { mes.m = 11; mes.y -= 1; }
    if (mes.m > 11) { mes.m = 0; mes.y += 1; }
    renderCalendario();
}

function reservasDelDia(fechaISO) {
    const sala = document.getElementById('filtroSalaCalendario')?.value || '';
    const soloDisp = document.getElementById('filtroDisponibles')?.value === 'Disponible';
    const ocupadas = new Set(reservasActivas().filter((r) => r.fecha === fechaISO).map((r) => r.espacio));
    return (window.RESERVAS || []).filter((r) => {
        if (r.fecha !== fechaISO) return false;
        if (sala && r.espacio !== sala) return false;
        if (soloDisp && ocupadas.has(r.espacio) && r.estado !== 'Cancelada') return false;
        return true;
    }).sort((a, b) => horaAMinutos(a.hora_inicio) - horaAMinutos(b.hora_inicio));
}

function renderCalendario() {
    const grid = document.getElementById('calendarioMes');
    const titulo = document.getElementById('tituloMes');
    if (!grid) return;
    const { y, m } = mesActual();
    const nombres = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    titulo.textContent = `${nombres[m]} ${y}`;

    const primero = new Date(y, m, 1);
    const offset = (primero.getDay() + 6) % 7;
    const dias = new Date(y, m + 1, 0).getDate();
    const sala = document.getElementById('filtroSalaCalendario')?.value || '';
    let html = '';
    for (let i = 0; i < offset; i++) html += '<div></div>';
    for (let d = 1; d <= dias; d++) {
        const iso = `${y}-${String(m + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
        const eventos = (window.RESERVAS || []).filter((r) => r.fecha === iso && r.estado !== 'Cancelada' && (!sala || r.espacio === sala));
        html += `<button type="button" class="cal-cell text-left bg-white border border-[#7A1A2E]/25 rounded-xl p-2 hover:border-[#7A1A2E]" onclick="seleccionarDia('${iso}')">
            <div class="text-xs font-bold text-[#7A1A2E]">${d}</div>
            ${eventos.map((e) => `<div class="cal-event"><b>${escapeHtml(e.espacio)}</b><br>${escapeHtml(e.actividad || 'Reserva')} · ${escapeHtml(e.hora_inicio)}-${escapeHtml(e.hora_fin)}</div>`).join('')}
        </button>`;
    }
    grid.innerHTML = html;
}

function seleccionarDia(iso) {
    window.FECHA_SELECCIONADA = iso;
    const inputFecha = document.getElementById('filtroFecha');
    if (inputFecha) inputFecha.value = iso;
}

function etiquetaFiltroReporte() {
    const sala = document.getElementById('filtroSalaCalendario')?.value || '';
    const soloDisp = document.getElementById('filtroDisponibles')?.value === 'Disponible';
    const partes = [sala ? `Sala: ${sala}` : 'Todas las salas'];
    if (soloDisp) partes.push('Solo espacios disponibles');
    return partes.join(' · ');
}

function fechaReporteActual() {
    return window.FECHA_SELECCIONADA || document.getElementById('filtroFecha')?.value || new Date().toISOString().slice(0, 10);
}

function cargarLogoPdf() {
    return new Promise((resolve) => {
        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.onload = () => {
            const canvas = document.createElement('canvas');
            canvas.width = img.naturalWidth;
            canvas.height = img.naturalHeight;
            canvas.getContext('2d').drawImage(img, 0, 0);
            resolve({ data: canvas.toDataURL('image/png'), w: img.naturalWidth, h: img.naturalHeight });
        };
        img.onerror = () => resolve(null);
        img.src = 'public/images/logo-fca.png';
    });
}

async function descargarReportePdf() {
    if (!window.jspdf?.jsPDF) {
        mostrarToast('No se pudo cargar la librería PDF. Revisa la conexión.');
        return;
    }

    const fecha = fechaReporteActual();
    window.FECHA_SELECCIONADA = fecha;
    const lista = reservasDelDia(fecha);
    const filtro = etiquetaFiltroReporte();
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });
    const vino = [122, 26, 46];
    const negro = [26, 26, 26];
    const ahora = new Date();
    const generado = ahora.toLocaleString('es-MX', { dateStyle: 'short', timeStyle: 'medium' });
    const logo = await cargarLogoPdf();

    if (logo) {
        const alto = 28;
        const ancho = (logo.w / logo.h) * alto;
        doc.addImage(logo.data, 'PNG', 14, 10, Math.min(ancho, 42), alto);
    }

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(16);
    doc.setTextColor(...vino);
    doc.text('Reporte del Día', 60, 18);
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(10);
    doc.setTextColor(...negro);
    doc.text('Facultad de Contaduría y Administración', 60, 25);
    doc.text(`Fecha del reporte: ${fecha}`, 60, 31);
    doc.text(`Filtro aplicado: ${filtro}`, 60, 37);

    const inicioTabla = 48;
    if (lista.length) {
        doc.autoTable({
            startY: inicioTabla,
            head: [['Hora inicio – Hora fin', 'Sala / Espacio', 'Actividad / Motivo', 'Usuario / Solicitante', 'Estado']],
            body: lista.map((r) => [
                `${r.hora_inicio} – ${r.hora_fin}`,
                r.espacio || '',
                r.actividad || '',
                r.responsable || '',
                r.estado || '',
            ]),
            styles: { fontSize: 9, textColor: negro, cellPadding: 3 },
            headStyles: { fillColor: vino, textColor: [255, 255, 255], fontStyle: 'bold' },
            alternateRowStyles: { fillColor: [247, 244, 245] },
            margin: { left: 14, right: 14, bottom: 18 },
        });
    } else {
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(...vino);
        doc.text('Sin reservas registradas para los criterios seleccionados.', 14, inicioTabla + 8);
        const disponibles = (window.ESPACIOS || []).filter((e) => e.estado === 'Disponible');
        if (disponibles.length) {
            doc.setFont('helvetica', 'normal');
            doc.setTextColor(...negro);
            doc.text('Salas disponibles:', 14, inicioTabla + 16);
            doc.autoTable({
                startY: inicioTabla + 20,
                head: [['Sala / Espacio', 'Tipo', 'Piso', 'Estado']],
                body: disponibles.map((e) => [e.nombre, e.tipo, e.piso, e.estado]),
                styles: { fontSize: 9, textColor: negro, cellPadding: 3 },
                headStyles: { fillColor: vino, textColor: [255, 255, 255], fontStyle: 'bold' },
                margin: { left: 14, right: 14, bottom: 18 },
            });
        }
    }

    const pageCount = doc.getNumberOfPages();
    for (let i = 1; i <= pageCount; i++) {
        doc.setPage(i);
        doc.setFontSize(8);
        doc.setTextColor(90, 90, 90);
        doc.text(
            `Generado: ${generado}  |  ${window.FACULTAD || 'FCA'}  |  Página ${i} de ${pageCount}`,
            14,
            doc.internal.pageSize.getHeight() - 8
        );
    }

    doc.save(`reporte-dia-FCA-${fecha}.pdf`);
}

function verReservasDelDia() {
    const fecha = window.FECHA_SELECCIONADA || document.getElementById('filtroFecha')?.value || new Date().toISOString().slice(0, 10);
    window.FECHA_SELECCIONADA = fecha;
    const lista = reservasDelDia(fecha);
    document.getElementById('tituloDia').textContent = fecha;
    const cuerpo = lista.length
        ? `<table class="w-full text-xs text-left"><thead><tr class="text-[#7A1A2E] uppercase">
            <th class="py-2">Hora inicio – Hora fin</th><th>Sala / Espacio</th><th>Actividad / Motivo</th><th>Usuario / Solicitante</th><th>Estado</th>
           </tr></thead><tbody>${lista.map((r) => `<tr class="border-t border-[#7A1A2E]/20">
            <td class="py-2">${escapeHtml(r.hora_inicio)} – ${escapeHtml(r.hora_fin)}</td>
            <td>${escapeHtml(r.espacio)}</td>
            <td>${escapeHtml(r.actividad || '')}</td>
            <td>${escapeHtml(r.responsable)}</td>
            <td>${escapeHtml(r.estado)}</td>
           </tr>`).join('')}</tbody></table>`
        : '<p class="text-sm text-[#7A1A2E]">Sin reservas registradas para los criterios seleccionados.</p>';
    document.getElementById('contenidoDia').innerHTML = cuerpo;
    document.getElementById('modalDia').classList.remove('hidden');
}

function filtrarTablaEspacios() {
    const tipo = document.getElementById('filtroTipo')?.value || '';
    const sala = document.getElementById('filtroSalaCalendario')?.value || '';
    const soloDisp = document.getElementById('filtroDisponibles')?.value === 'Disponible';
    document.querySelectorAll('.fila-aula').forEach((fila) => {
        const okTipo = !tipo || fila.dataset.tipo === tipo;
        const okSala = !sala || fila.dataset.nombre === sala;
        const okDisp = !soloDisp || fila.dataset.estado === 'Disponible';
        fila.style.display = okTipo && okSala && okDisp ? '' : 'none';
    });
}

function agregarFilaHistorial(reserva) {
    const tbody = document.getElementById('tablaHistorialReservas');
    if (!tbody) return;
    document.getElementById('historialVacio')?.remove();
    const tr = document.createElement('tr');
    tr.className = 'hover:bg-[#7A1A2E]/10 transition';
    tr.innerHTML = `
        <td class="px-5 py-4 font-bold">${escapeHtml(reserva.responsable)}</td>
        <td class="px-5 py-4">${escapeHtml(reserva.espacio)}</td>
        <td class="px-5 py-4">${escapeHtml(reserva.actividad)}</td>
        <td class="px-5 py-4 whitespace-nowrap">${escapeHtml(reserva.fecha)}</td>
        <td class="px-5 py-4 whitespace-nowrap">${escapeHtml(reserva.hora_inicio)} – ${escapeHtml(reserva.hora_fin)}</td>
        <td class="px-5 py-4 text-xs">${renderInsumos(reserva.insumos)}</td>
        <td class="px-5 py-4">${escapeHtml(reserva.estado)}</td>`;
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
    const inicio = document.getElementById('resHoraInicio').value;
    const fin = document.getElementById('resHoraFin').value;
    const responsable = document.getElementById('resResponsable').value;
    const actividad = document.getElementById('resActividad').value;
    const insumos = insumosPermitidos(espacio);
    const alerta = document.getElementById('alertaReserva');
    const error = validarReserva(espacio, fecha, inicio, fin);
    if (error) {
        alerta.textContent = error;
        alerta.classList.remove('hidden');
        return false;
    }

    const reserva = {
        responsable, espacio, fecha, hora_inicio: inicio, hora_fin: fin,
        actividad, estado: 'Confirmada', insumos,
        facultad: window.FACULTAD
    };
    window.RESERVAS.push(reserva);
    agregarFilaHistorial(reserva);
    incrementarMetrica('metricaTotalReservas');
    incrementarMetrica('metricaConfirmadas');
    const contador = document.getElementById('contadorRegistros');
    const total = document.getElementById('metricaTotalReservas');
    if (contador && total) contador.textContent = total.textContent + ' registros';
    renderCalendario();
    mostrarToast(`Reserva guardada: ${actividad} en ${espacio}`);
    cerrarModalReserva();
    e.target.reset();
    return false;
}

function mostrarToast(mensaje) {
    const toast = document.getElementById('toast');
    const msg = document.getElementById('toastMsg');
    msg.textContent = mensaje;
    toast.classList.remove('hidden');
    clearTimeout(window._toastTimeout);
    window._toastTimeout = setTimeout(() => toast.classList.add('hidden'), 4000);
}

document.addEventListener('DOMContentLoaded', () => {
    window.FECHA_SELECCIONADA = new Date().toISOString().slice(0, 10);
    const filtroFecha = document.getElementById('filtroFecha');
    if (filtroFecha) filtroFecha.value = window.FECHA_SELECCIONADA;
    actualizarInsumosPorEspacio();
    renderCalendario();
});
