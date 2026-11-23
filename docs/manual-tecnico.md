# Manual técnico — AulasHub (FCA)

## 1. Descripción

Prototipo web en **PHP plano (MVC básico)** para reservar espacios de la Facultad de Contaduría y Administración. Los datos de prueba viven en modelos PHP; hay scripts SQL de semilla para cuando se migre a MySQL.

## 2. Tecnologías

| Capa | Tecnología |
|---|---|
| Backend | PHP 8+ (sesiones, MVC mínimo) |
| Frontend | HTML, Tailwind CDN, JavaScript (`public/js/app.js`) |
| PDF | jsPDF + jspdf-autotable (CDN) |
| Identidad | Logo `public/images/logo-fca.png`, paleta guinda `#7A1A2E` |
| Datos actuales | Arreglos en `models/` |
| Seeds SQL | `seed/*.sql` (esquema objetivo) |

## 3. Estructura del proyecto

```
AulasHub/
  index.php                 Enrutador (?action=login|index|logout)
  controllers/AulaController.php
  models/Aula.php           Espacios, insumos, horario operativo
  models/Reserva.php        Reservas de demostración
  models/Usuario.php        Autenticación y perfiles
  views/login.php
  views/consulta.php        Vista docente
  views/admin.php           Panel administrativo
  views/partials/           header, modal, calendario, config-js
  public/css/fca.css
  public/js/app.js
  public/images/logo-fca.png
  seed/usuarios.sql
  seed/espacios.sql
  seed/insumos.sql
  docs/                     Manuales y diagrama de clases
```

La carpeta `proyecto/` es un sistema anterior no usado por AulasHub; no forma parte de la entrega funcional.

## 4. Instalación y ejecución (XAMPP)

1. Copiar el código a `C:\xampp\htdocs\AulasHub`.
2. Iniciar **Apache** (MySQL solo si vas a cargar los `.sql`).
3. Abrir `http://localhost/AulasHub/`.
4. El prototipo **no requiere MySQL** para funcionar: autentica contra `models/Usuario.php`.

### 4.1 Carga opcional de MySQL

Cuando exista una base `aulashub`:

```sql
CREATE DATABASE aulashub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Importar, en este orden: `seed/usuarios.sql`, `seed/espacios.sql`, `seed/insumos.sql`.  
**Nota:** el código PHP aún no consulta esas tablas; son el esquema/seed de respaldo para la rúbrica y la migración futura.

## 5. Respaldo y restauración

### Respaldo (cuando ya exista MySQL)

```bash
mysqldump -u root -p aulashub > aulashub-backup.sql
```

Incluir en el `.zip` el dump **sin** archivos `.env` ni contraseñas de producción.

### Restauración

```bash
mysql -u root -p aulashub < aulashub-backup.sql
```

En el prototipo actual, un “respaldo” de datos de demo es copiar `models/` y `seed/`.

## 6. Accesos de prueba (sin contraseñas)

Solicitar la contraseña de laboratorio al responsable del proyecto. Cuentas previstas:

**Administrativos**

| Usuario | Perfil |
|---|---|
| `secretaria_matutino` | Secretaria turno matutino |
| `secretaria_vespertino` | Secretaria turno vespertino |
| `secretaria_2piso` | Secretaria turno matutino 2do piso |
| `coordinacion_virtual` | Coordinación Modalidad Virtual |
| `secretaria_academica` | Secretaria académica |

**Docentes / consulta**

| Usuario | Perfil |
|---|---|
| `maestro1` | maestro 1 |
| `maestro2` | maestro 2 |

El rol se resuelve en autenticación (`admin` → `views/admin.php`, `consulta` → `views/consulta.php`).

## 7. Reglas de negocio relevantes

- 4 espacios: Aula Virtual, Auditorio, una sala de juntas por piso.
- Reserva con `hora_inicio` y `hora_fin`; fin > inicio; sin traslape; dentro del horario de facultad y de usuario.
- **Presídium** solo si el espacio es Auditorio (`Insumo.solo_auditorio` / validación en `public/js/app.js`).
- No existe insumo de sillas.
- PDF del reporte del día: cliente, sin persistir archivo.

Diagrama: `docs/diagrama-clases-bd.md`.
