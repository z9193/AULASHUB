# Manual de usuario — AulasHub (FCA)

Sistema de consulta y reserva de espacios de la **Facultad de Contaduría y Administración**.

> Coloca aquí las capturas reales cuando las tengas. En cada sección hay un marcador `[CAPTURA]`.

## 1. Inicio de sesión

1. Abre el sistema en el navegador (`http://localhost/AulasHub/` en el entorno de pruebas).
2. Ingresa **usuario** y **contraseña**.
3. Pulsa **Iniciar sesión**.
4. Según tu perfil, entrarás a la vista de **docente/consulta** o al **panel administrativo**. El rol no se muestra en pantalla.

[CAPTURA: pantalla de login con logo FCA]

Para **cerrar sesión**, usa el botón del encabezado.

[CAPTURA: encabezado con usuario y Cerrar sesión]

## 2. Vista docente (consulta)

### 2.1 Directorio de espacios

Verás: **Aula Virtual**, **Auditorio**, **Sala de juntas - 1er piso** y **Sala de juntas - 2do piso**.

- Filtra por **fecha** y **tipo** (Aula, Auditorio, Sala de juntas).
- Tu **horario autorizado** aparece en el panel.
- **Reservar** abre el formulario de nueva reserva.

[CAPTURA: directorio de espacios]

### 2.2 Calendario e indicadores

El calendario mensual muestra, en cada día, **qué actividad** hay en cada sala (espacio + motivo + horario).

- Flechas para cambiar de mes.
- Filtro por **sala**.
- Filtro **solo espacios disponibles**.
- Clic en un día para seleccionarlo.
- **Ver reservas del día** abre el reporte de esa fecha.

[CAPTURA: calendario con bloques de actividad]

### 2.3 Nueva reserva (hora inicio y hora fin)

1. Elige **espacio**.
2. Escribe **actividad / motivo**.
3. Elige **fecha**, **hora de inicio** y **hora de fin** (la fin debe ser posterior a la inicio).
4. Confirma el **responsable**.
5. Marca **insumos** si los necesitas.
   - **Presídium** solo aparece si el espacio es **Auditorio**.
   - No hay opción de sillas.
6. **Guardar reserva**. El sistema valida horario operativo, tu horario de usuario y que no choque con otra reserva del mismo espacio.

[CAPTURA: modal de reserva en Auditorio con Presídium]
[CAPTURA: modal de reserva en sala de juntas sin Presídium]

### 2.4 Requisitos del usuario

En la vista docente se listan los **requisitos** asociados a tu perfil (por ejemplo carga académica o correo institucional).

[CAPTURA: bloque de requisitos]

## 3. Panel administrativo

Acciones principales (tarjetas guinda):

- **Nueva reserva** — mismo formulario que en consulta.
- **Reporte del día** — listado del día seleccionado (respeta filtros de sala y disponibilidad).

Las tarjetas **Disponibles** y **Pendientes** son indicadores. Debajo está el listado de espacios y el **historial de reservas**.

[CAPTURA: panel administrativo con las dos tarjetas de acción]

## 4. Reporte del día y PDF

1. Selecciona fecha en el calendario o en el filtro.
2. Opcional: filtra sala o “solo disponibles”.
3. Abre **Reporte del día**.
4. Pulsa **Descargar PDF**.

El archivo se llama `reporte-dia-FCA-YYYY-MM-DD.pdf` e incluye logo FCA, fecha, filtro aplicado, tabla de reservas y pie con fecha/hora de generación. Si no hay datos, indica que no hay reservas para esos criterios.

[CAPTURA: modal reporte del día con botón Descargar PDF]
[CAPTURA: primera página del PDF generado]

## 5. Espacios e insumos (recordatorio)

| Espacio | Presídium | Sillas |
|---|---|---|
| Auditorio | Sí, opcional | No existe |
| Aula Virtual | No | No existe |
| Sala de juntas - 1er piso | No | No existe |
| Sala de juntas - 2do piso | No | No existe |
