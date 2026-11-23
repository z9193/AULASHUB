# Borrador de presentación — Día de presentaciones

**Proyecto:** AulasHub  
**Institución:** Facultad de Contaduría y Administración  
**Tiempo sugerido:** 8–12 minutos + preguntas

---

## 1. Problema (1–2 min)

- La gestión de **aula virtual, auditorio y salas de juntas** se hacía de forma dispersa (correo, lista, pizarra).
- No era claro **qué ocurría en cada sala y a qué hora**.
- Había riesgo de **traslapes**, pedidos de insumos que no aplican al espacio (p. ej. presídium en un aula) y falta de un **reporte del día** para secretaría.
- Distintos turnos (matutino, vespertino, 2do piso, modalidad virtual, secretaría académica) necesitan **el mismo tablero**, no una hoja distinta.

**Mensaje:** “No sabíamos con certeza qué espacio estaba ocupado, con qué actividad y con qué recursos.”

[Diapositiva: foto o captura del flujo anterior / lista de dolores]

---

## 2. Solución (2–3 min)

AulasHub es un prototipo web institucional (logo y color guinda FCA) que:

- Separa **consulta docente** y **panel administrativo** según la cuenta.
- Muestra un **calendario mensual** con la actividad de cada sala.
- Permite reservar con **hora de inicio y hora de fin**, validando choques y horarios.
- Limita **Presídium al Auditorio** y elimina insumos que no aplican (sillas).
- Ofrece **reporte del día** y **descarga PDF** para archivo o junta.

Espacios cubiertos: Aula Virtual, Auditorio, Sala de juntas 1er piso, Sala de juntas 2do piso.

[Diapositiva: esquema de 4 espacios + dos perfiles de usuario]

---

## 3. Demostración (4–5 min)

Guion sugerido (en vivo o video corto):

1. Login docente (`maestro1`) — sin mostrar contraseña en la diapositiva.
2. Calendario: señalar un día con bloques de actividad.
3. Reservar **Auditorio**: mostrar que aparece Presídium.
4. Cambiar a **sala de juntas**: Presídium desaparece.
5. Cerrar sesión → login administrativo (`secretaria_academica`).
6. Tarjeta **Nueva reserva** y tarjeta **Reporte del día**.
7. **Descargar PDF** y abrir el archivo (`reporte-dia-FCA-AAAA-MM-DD.pdf`).

[Diapositivas: 3–4 capturas o demo en pantalla]

---

## 4. Resultados (1–2 min)

- Un solo lugar para **ver, reservar y reportar** espacios FCA.
- Menos ambigüedad: **una sala por piso**, insumos correctos por tipo de espacio.
- Entregable operativo para secretaría: **PDF del día** con logo institucional.
- Base lista para migrar a MySQL (`seed/`) sin cambiar la lógica de negocio.

**Próximos pasos (si preguntan):** persistir reservas en BD, prueba con una persona del área, despliegue en el servidor de la facultad.

---

## Notas para el presentador

- No proyectar la contraseña de laboratorio.
- Tener un PDF ya generado por si falla el CDN de jsPDF.
- Si no hay red, el login y las reservas locales siguen funcionando; el PDF necesita las librerías CDN o caché del navegador.
