# TODO - Copias de seguridad automáticas

- [x] Revisar cómo está la conexión a MySQL y qué nombre de base se usa.
- [x] Crear un script PHP que ejecute `mysqldump`.
- [x] Asegurar que la carpeta `respaldos/` exista y guardar backups con timestamp.
- [ ] Programar la ejecución diaria a las 08:30 (Task Scheduler en Windows).
- [ ] Probar el script ejecutándolo manualmente y validando que se generen archivos en `respaldos/`.
- [ ] Ajustar retención (se implementó conservar últimos 30 backups).


