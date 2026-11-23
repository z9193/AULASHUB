# Checklist para el `.zip` de entrega

Nombre sugerido: `AulasHub-FCA-codigo-fuente.zip`

## Incluir

- [ ] `index.php`
- [ ] `controllers/`
- [ ] `models/`
- [ ] `views/` (login, consulta, admin, partials, helpers)
- [ ] `public/css/`, `public/js/`, `public/images/logo-fca.png`
- [ ] `seed/usuarios.sql`, `seed/espacios.sql`, `seed/insumos.sql`
- [ ] `docs/` (manuales, diagrama, presentación, este checklist)
- [ ] Exportación de BD **si ya existe MySQL**: `aulashub-backup.sql` (o los tres seeds si aún no hay dump real)
- [ ] `README.md` (raíz: instalación XAMPP, estructura y nota de seguridad)

## Excluir

- [ ] Carpeta `.git/`
- [ ] Carpeta `proyecto/` (sistema viejo, no es AulasHub)
- [ ] `node_modules/` (no aplica)
- [ ] `.env`, `credentials.json`, archivos con contraseñas de producción
- [ ] Caché de IDE: `.cursor/`, `.vscode/` (opcional excluir)
- [ ] Capturas con datos personales o contraseñas visibles
- [ ] `public/images/README.txt` no es crítico; el logo PNG sí va

## Contraseñas y secretos

- El seed `usuarios.sql` contiene hashes/claves de **laboratorio**. Si la rúbrica pide no incluir secretos, entrega el SQL de **estructura** (`CREATE TABLE`) y un listado de usuarios **sin** la columna `password`, o indica “credenciales en sobre cerrado / responsable del laboratorio”.
- El manual técnico **no** publica la contraseña; no la escribas en diapositivas.

## Verificación rápida antes de comprimir

1. Login abre sin el bloque de usuarios de prueba.
2. Hay 4 espacios (2 salas de juntas, una por piso).
3. Presídium solo en Auditorio; no hay sillas.
4. PDF del reporte del día descarga.
5. El zip se abre en otra PC con XAMPP y la ruta `htdocs/AulasHub`.
