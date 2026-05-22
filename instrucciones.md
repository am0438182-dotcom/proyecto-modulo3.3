# Instrucciones de instalación del sistema

1. Instalar XAMPP o un servidor local compatible con PHP y MySQL.

2. Copiar la carpeta del proyecto `marketplace express` a la carpeta de htdocs de XAMPP (por ejemplo, `C:\xampp\htdocs\marketplace express`).

3. Iniciar Apache y MySQL desde el panel de control de XAMPP.

4. Abrir `phpMyAdmin` en el navegador: `http://localhost/phpmyadmin`.

5. Crear una base de datos nueva (por ejemplo, `marketplace_db`).

6. Importar el archivo `database.sql` desde el proyecto en `phpMyAdmin`.

7. Abrir el archivo `conexion.php` y verificar los datos de conexión:
   - servidor: `localhost`
   - usuario: `root`
   - contraseña: `` (vacía por defecto en XAMPP)
   - nombre de la base de datos: `marketplace_db` o el nombre que hayas usado.

8. Abrir el proyecto en el navegador:
   - `http://localhost/marketplace express/`

9. Si el sistema no carga, revisar que:
   - Apache y MySQL estén ejecutándose.
   - la carpeta del proyecto esté en `htdocs`.
   - la base de datos se haya importado correctamente.

10. Para acceder al sistema, usar las credenciales registradas o crear un nuevo usuario desde `registro.php`.

Nota: si se usa VS Code agregar las extensiones PHP Intelephense y PHP Server, si conoces cómo puedes consultar este video "https://www.youtube.com/watch?v=DSDrKE4XIMk".