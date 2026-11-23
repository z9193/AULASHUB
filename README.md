# AulasHub — Facultad de Contaduría y Administración

Sistema de reserva de espacios (Aula Virtual, Auditorio y salas de juntas de 1er y 2do piso). Prototipo en PHP con MVC básico.

## 1. Requisitos e instalación (XAMPP)

**Requisitos:** XAMPP con Apache y PHP 8+. MySQL es opcional: la aplicación funciona con los datos de `models/` y no consulta las tablas todavía. Hace falta conexión a internet para Tailwind, fuentes y jsPDF (CDN).

1. Copia o extrae el proyecto en `C:\xampp\htdocs\AulasHub` (la carpeta debe llamarse `AulasHub`).
2. Inicia **Apache** desde el panel de XAMPP.
3. Abre [http://localhost/AulasHub/](http://localhost/AulasHub/) (con barra final). Debe mostrarse el inicio de sesión.

Las cuentas de laboratorio se entregan por el responsable del proyecto; **no se documentan contraseñas aquí**.

### Importación de base de datos / seeds (opcional)

Cuando quieras dejar semilla MySQL para la rúbrica o una migración posterior:

1. Inicia **MySQL** en XAMPP.
2. En phpMyAdmin o consola, crea la base:

```sql
CREATE DATABASE aulashub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE aulashub;
```

3. Importa, en este orden: `seed/usuarios.sql`, `seed/espacios.sql`, `seed/insumos.sql`.

Si ya tienes un dump (`aulashub-backup.sql`), impórtalo sobre esa base. El PHP actual **no lee** MySQL; los seeds son el esquema y los datos de respaldo.

## 2. Estructura general

```
AulasHub/
  index.php          Enrutador (?action=login|index|logout)
  controllers/       AulaController.php
  models/            Espacios, reservas y usuarios de demostración
  views/             login, consulta, admin y partials
  public/            css/, js/, images/ (logo FCA)
  seed/              usuarios.sql, espacios.sql, insumos.sql
  docs/              Manuales, diagrama, presentación y checklist del zip
```

La carpeta `proyecto/` (si aparece) es un sistema anterior y **no** forma parte de AulasHub.

## 3. Seguridad al empaquetar la entrega

No incluyas en el `.zip`:

- archivos `.env`, `credentials.json` u otros secretos
- contraseñas de producción o de laboratorio en el README, diapositivas o capturas
- carpeta `.git/` ni `proyecto/`

Los seeds de laboratorio pueden contener claves de prueba. Si la rúbrica pide no incluir secretos, entrega solo la estructura SQL y el listado de usuarios **sin** columna de contraseña. Detalle en `docs/checklist-zip.md`.

## Rutas y `http://localhost/AulasHub/`

Los includes PHP usan `__DIR__` (relativos al archivo). CSS, JS, logo y redirecciones (`?action=login`, `?action=index`) son **rutas relativas** al directorio del proyecto, no rutas `C:\...` ni `/` desde la raíz del servidor.

Usa la URL con el nombre de carpeta: `http://localhost/AulasHub/` o `http://localhost/AulasHub/index.php`. No abras archivos de `views/` directo en el navegador (romperían `public/css` y `public/js`).
