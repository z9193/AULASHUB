<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard de Nodos & Métricas - CGTI</h1>
        <button class="btn btn-primary shadow-sm" onclick="cargarTodo()">
            <i class="fas fa-sync-alt fa-sm text-white-50"></i> Actualizar Todo
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-light">
            <h6 class="m-0 font-weight-bold text-primary" id="titulo-grafica">
                <i class="fas fa-chart-bar"></i> Tiempo Caído por Departamento (Minutos)
            </h6>
            <button id="btn-regresar" class="btn btn-secondary btn-sm d-none" onclick="regresarNivel()">
                <i class="fas fa-arrow-left fa-sm"></i> Volver
            </button>
        </div>
        <div class="card-body">
            <div id="contenedor-canvas" style="position: relative; height:35vh; width:100%">
                <canvas id="graficaNiveles"></canvas>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-light">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-network-wired"></i> Estado de Nodos en Tiempo Real (Orion)
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Nombre del Nodo</th>
                            <th>Dirección IP</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-nodos">
                        <tr>
                            <td colspan="3" class="text-center text-muted">Cargando datos desde SolarWinds...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let miGrafica  = null;
let nivelActual = "mes";   // inicio: meses del año
let filtroMes   = 0;
let filtroDia   = 0;

const NOMBRES_MESES = {
    1:"Enero", 2:"Febrero", 3:"Marzo", 4:"Abril",
    5:"Mayo", 6:"Junio", 7:"Julio", 8:"Agosto",
    9:"Septiembre", 10:"Octubre", 11:"Noviembre", 12:"Diciembre"
};

function obtenerBadgeEstado(status) {
    return status == 1
        ? '<span class="badge bg-success px-3 py-2"><i class="fas fa-chevron-up"></i> UP</span>'
        : '<span class="badge bg-danger  px-3 py-2"><i class="fas fa-chevron-down"></i> DOWN</span>';
}

// ── 1. TABLA EN VIVO (SOLARWINDS ORION) ─────────────────────────────
async function cargarTablaNodos() {
    const tbody = document.getElementById('tabla-nodos');
    if (!tbody) return;
    
    try {
        const res  = await fetch('/proyecto/ajax/nodoAjax.php');
        const data = await res.json();

        tbody.innerHTML = '';
        if (data.status === "error" || !data.results) {
            tbody.innerHTML = `<tr><td colspan="3" class="text-danger text-center">${data.message || 'Error'}</td></tr>`;
            return;
        }
        data.results.forEach(nodo => {
            const tr = document.createElement('tr');
            tr.className = "text-center align-middle";
            tr.innerHTML = `
                <td class="text-start fw-bold">${nodo.Caption}</td>
                <td><code>${nodo.IPAddress}</code></td>
                <td>${obtenerBadgeEstado(nodo.Status)}</td>`;
            tbody.appendChild(tr);
        });
    } catch(e) {
        tbody.innerHTML = `<tr><td colspan="3" class="text-danger text-center">Error de conexión con el backend</td></tr>`;
    }
}

// ── 2. GRÁFICA DINÁMICA E HÍBRIDA (CON LIMPIEZA DE RESIDUOS) ─────────
async function cargarGrafica(urlParams) {
    try {
        const res   = await fetch(`/proyecto/ajax/graficaAjax.php?${urlParams}`);
        const texto = await res.text();
        
        let datos;
        try {
            datos = JSON.parse(texto);
        } catch(e) {
            console.error("El backend no devolvió JSON válido. Devolvió:", texto);
            return;
        }

        const contenedor = document.getElementById('contenedor-canvas');
        if (!contenedor) return;

        // Si no hay datos, limpiamos la instancia y mostramos mensaje
        if (!Array.isArray(datos) || datos.length === 0) {
            contenedor.innerHTML = '<p class="text-center text-muted py-4">Sin datos para mostrar.</p>';
            if (miGrafica) {
                miGrafica.destroy();
                miGrafica = null;
            }
            return;
        }

        // Destruir la instancia lógica previa de Chart.js si existe
        if (miGrafica) {
            miGrafica.destroy();
            miGrafica = null;
        }

        // Re-inyectar un elemento canvas completamente virgen al DOM para resetear el buffer gráfico
        contenedor.innerHTML = '<canvas id="graficaNiveles"></canvas>';

        const labels = datos.map(item =>
            nivelActual === "mes" ? (NOMBRES_MESES[item.label] || item.label) : item.label
        );
        const valores = datos.map(item => item.total_minutos);

        // Configuración visual por nivel
        let tipoGrafica = 'bar'; 
        let coloresBg = 'rgba(78,115,223,0.75)';
        let coloresBorder = 'rgba(78,115,223,1)';

        // Transformación estética a Dona en el drilldown de equipos
        if (nivelActual === "equipo") {
            tipoGrafica = 'doughnut'; 
            coloresBg = [
                'rgba(231, 74, 59, 0.8)',  
                'rgba(246, 194, 62, 0.8)', 
                'rgba(28, 200, 138, 0.8)', 
                'rgba(54, 185, 204, 0.8)', 
                'rgba(111, 66, 193, 0.8)', 
                'rgba(253, 126, 20, 0.8)'  
            ];
            coloresBorder = [
                '#e74a3b', '#f6c23e', '#1cc88a', '#36b9cc', '#6f42c1', '#fd7e14'
            ];
        }

        // Obtener el contexto del nuevo canvas recién creado
        const ctx = document.getElementById('graficaNiveles').getContext('2d');

        miGrafica = new Chart(ctx, {
            type: tipoGrafica,
            data: {
                labels,
                datasets: [{
                    label: 'Minutos Fuera de Servicio',
                    data: valores,
                    backgroundColor: coloresBg,
                    borderColor:     coloresBorder,
                    borderWidth: 1,
                    borderRadius: tipoGrafica === 'bar' ? 4 : 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                // Configuración limpia y estética del Eje Y Logarítmico
                scales: tipoGrafica === 'bar' ? { 
                    y: { 
                        type: 'logarithmic',
                        beginAtZero: false, 
                        min: 10, // Evita colapsar barras pequeñas en la base
                        ticks: {
                            // Definimos saltos lógicos estables para evitar el amontonamiento visual
                            forcedValues: [10, 100, 1000, 10000, 40000], 
                            callback: function(value) {
                                if (value === 10 || value === 100 || value === 1000 || value === 10000 || value === 40000) {
                                    return Number(value).toLocaleString() + " min";
                                }
                                return null; 
                            }
                        }
                    } 
                } : {},
                plugins: {
                    legend: {
                        display: tipoGrafica !== 'bar', 
                        position: 'bottom'
                    },
                    // Tooltip profesional para ver el valor exacto en minutos al pasar el mouse
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ` Tiempo caído: ${Number(context.raw).toLocaleString()} minutos`;
                            }
                        }
                    }
                },
                onClick: (e, elementos) => {
                    if (elementos.length > 0 && nivelActual !== "equipo") {
                        manejarClicGrafica(datos[elementos[0].index].label);
                    }
                }
            }
        });
    } catch(e) {
        console.error("Error cargando componentes de la gráfica:", e);
    }
}

// ── 3. MANEJAR CLIC DRILLDOWN ───────────────────────────────────────
function manejarClicGrafica(valor) {
    if (nivelActual === "mes") {
        filtroMes = valor;   
        nivelActual = "dia";
        document.getElementById('titulo-grafica').innerHTML =
            `<i class="fas fa-calendar-day"></i> Días con caídas: <b>${NOMBRES_MESES[valor]}</b>`;
        document.getElementById('btn-regresar').classList.remove('d-none');
        cargarGrafica(`nivel=dia&mes=${filtroMes}`);
    }
    else if (nivelActual === "dia") {
        filtroDia = valor;   
        nivelActual = "equipo";
        document.getElementById('titulo-grafica').innerHTML =
            `<i class="fas fa-desktop"></i> Equipos caídos: día <b>${filtroDia}</b> de ${NOMBRES_MESES[filtroMes]}`;
        cargarGrafica(`nivel=equipo&mes=${filtroMes}&dia=${filtroDia}`);
    }
}

// ── 4. BOTÓN VOLVER / REGRESAR NIVEL ───────────────────────────────
function regresarNivel() {
    if (nivelActual === "equipo") {
        nivelActual = "dia";
        document.getElementById('titulo-grafica').innerHTML =
            `<i class="fas fa-calendar-day"></i> Días con caídas: <b>${NOMBRES_MESES[filtroMes]}</b>`;
        cargarGrafica(`nivel=dia&mes=${filtroMes}`);
    }
    else if (nivelActual === "dia") {
        nivelActual = "mes";
        filtroMes = 0;
        document.getElementById('titulo-grafica').innerHTML =
            `<i class="fas fa-chart-bar"></i> Tiempo Caído por Mes (Minutos)`;
        document.getElementById('btn-regresar').classList.add('d-none');
        cargarGrafica("nivel=mes");
    }
}

// ── 5. DISPARADOR GLOBAL PRINCIPAL ──────────────────────────────────
function cargarTodo() {
    cargarTablaNodos();
    cargarGrafica("nivel=mes");
}

// ── 6. MONITOREO REAL AUTOMÁTICO EN SEGUNDO PLANO ───────────────────
// Ejecuta el cURL a SolarWinds y actualiza la UI automáticamente cada 5 minutos
setInterval(() => {
    console.log("Actualizando métricas de Orion automáticamente...");
    cargarTablaNodos(); 
    
    if (nivelActual === "mes") cargarGrafica("nivel=mes");
    else if (nivelActual === "dia") cargarGrafica(`nivel=dia&mes=${filtroMes}`);
    else if (nivelActual === "equipo") cargarGrafica(`nivel=equipo&mes=${filtroMes}&dia=${filtroDia}`);
}, 300000); // 300,000 ms = 5 minutos

// Carga automática inicial al abrir la página
document.addEventListener("DOMContentLoaded", cargarTodo);
</script>