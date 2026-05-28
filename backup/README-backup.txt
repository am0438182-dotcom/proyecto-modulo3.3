Pasos para configurar copias de seguridad diarias a las 08:30

1) Definir variables de conexión para el backup
   En el proyecto, crea/edita un archivo de configuración para el backup con constantes:

   DB_HOST
   DB_NAME
   DB_USER
   DB_PASS (opcional)

   Recomendación: define estas constantes en conexion.php o crea un archivo incluido.

2) Crear el scheduler
   Esta app por sí sola NO tiene un scheduler interno fiable.
   Recomendado en Windows (Task Scheduler):

   - Programar tarea: Diariamente
   - Hora: 08:30
   - Acción: ejecutar PHP con el script

   Ejemplo (ajusta la ruta a php.exe):
   "C:\\xampp\\php\\php.exe" "C:\\xampp\\htdocs\\marketplace express\\backup\\backup.php"

3) Carpeta de salida
   Los backups se guardarán en:
   marketplace express/respaldos/

Notas
- El script usa mysqldump y gzip (PHP) para comprimir.
- Asegúrate de que mysqldump esté disponible en el PATH o que el comando funcione desde consola.

